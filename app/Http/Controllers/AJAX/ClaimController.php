<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimPostRequest;
use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Provider;
use Box\Spout\Common\Exception\IOException;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Collection;
use PHPUnit\Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class ClaimController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('claim.service.clean')->only('store');
    }

    public function index()
    {
        $claims = Claim::getClaims();

        if(Auth::user()->hasRole('provider')) {
            $claims->where('provider_id',Auth::user()->id);
        }

        if(Auth::user()->hasRole('representative')) {
            $claims->whereIn('participant_id',Auth::user()->representative->participants()->pluck('user_id'));
        }

        return  $claims->paginate(5);
    }

    public function index2()
    {
        $claims = ClaimLineItem::getClaims();

        if(Auth::user()->hasRole('provider')) {
            $claims->where('provider_id',Auth::user()->id);
        }

        if(Auth::user()->hasRole('representative')) {
            $claims->whereIn('participant_id',Auth::user()->representative->participants()->pluck('user_id'));
        }

        return  $claims->orderBy('created_at','DESC')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaimPostRequest $request)
    {
        $user = \auth();
        $provider = optional(\auth()->user())->provider;
        $isRepresentative = false;
        if(!$provider){
            $representative = optional(\auth()->user())->representative;
            if(!$representative){
                return $this->respondNotFound(__('record.not_found',['model'=>'Provider']));
            }
            $isRepresentative = true;
            $provider = Provider::find($request->provider_id);
        }

        $participant = Participant::find($request->participant_id);

        DB::beginTransaction();

        $path = $request->file('file')->store('claims');

        $claim = $provider->claims()->create(
            array_merge($request->all(),[
                'ndis_number' => $participant->ndis_number,
                'provider_abn' => $isRepresentative ? 'REIMB' : $provider->abn ,
                'status' =>  $isRepresentative ? Claim::STATUS_APPROVED_BY_REPRESENTATIVE : Claim::STATUS_APPROVAL_PENDING,
                'invoice_path' => $path
            ])
        );

        foreach ($request->service as $index => $item) {
            $key = $index + 1;
            $item = array_merge($item,[
                'status' =>  $isRepresentative ? Claim::STATUS_APPROVED_BY_REPRESENTATIVE : Claim::STATUS_APPROVAL_PENDING,
                'claim_reference' => "{$claim->id}_{$key}",
                'provider_id' => $provider->user_id,
                'participant_id' => $participant->user_id,
                'amount_claimed' => $item['hours'] * $item['unit_price']
            ]);
            $claim->items()->create($item);
        }
        DB::commit();
        return $this->respondCreated();

    }

    public function approvedByRepresentative(Request $request,ClaimLineItem $claim) {

        if(!Auth::user()->hasRole('representative')) {
            return $this->respondForbidden();
        }

        if($claim->status != Claim::STATUS_APPROVAL_PENDING ){
            return $this->respondForbidden();
        }

        $request->validate(['status'=> 'required',Rule::in([Claim::STATUS_APPROVED_BY_REPRESENTATIVE,Claim::STATUS_DENIED_BY_REPRESENTATIVE])]);

        $claim->status = $request->status;
        //$claim->rejection_reason = $request->reason;
        $claim->save();

        return $this->respondWithSuccess();
    }

    public function approveClaimsByAdmin(Request $request)
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('approving_claims')){
            return $this->respondForbidden();
        }

        ClaimLineItem::whereIn('id',$request->claims)->update(['status'=> Claim::STATUS_APPROVED_BY_ADMIN]);
        return $this->respondWithSuccess();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|string|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function bulkUploadFile()
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('export_import_documents')) {
            return $this->respondForbidden();
        }

        $items = ClaimLineItem::with('claim')->where('status',Claim::STATUS_APPROVED_BY_ADMIN);
        if(\request()->method() == Request::METHOD_POST){
            $items->whereIn('id',explode(',',\request()->claims));
        }
        $itemsUpdate = $items;
        $items = $items->get();

        $itemsUpdate->update(['status' => Claim::STATUS_PROCESSED]);

        $name = Carbon::now()->format('YmdHi'). '.csv';

        return (new FastExcel($items))->download($name, function ($item) {
            return [
                'RegistrationNumber' => env('EIN_REGISTRATION_NUMBER','N/A'),
                'NdisNumber' => (string) $item->claim->ndis_number,
                'SupportDeliveredFrom' => Carbon::create($item->claim->start_date)->format('Y-m-d'),
                'SupportsDeliveredTo' => Carbon::create($item->claim->end_date)->format('Y-m-d'),
                'SupportNumber' => $item->support_item_number,
                'ClaimReference' => 'A'.$item->claim_reference,
                'Quantity' => $item->hours,
                'Hours' => null,
                'UnitPrice' => $item->unit_price,
                'GstCode' => $item->gst_code,
                'AuthorisedBy' => '',
                'ParticipantApproved' => '',
                'GstCode' => $item->gst_code,
                'InKindFundingProgram' => '',
                'ClaimType' => $item->claim_type,
                'CancellationReason' => $item->cancellation_reason,
                'ABN of Support Provider' => $item->claim->provider_abn,
                'ServiceBookingNumber' => null
            ];
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse|string|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function reconciledResultsFile()
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('export_import_documents')) {
            return $this->respondForbidden();
        }
        $items = ClaimLineItem::with('claim','claim.provider.user','claim.participant.user')->where('status',Claim::STATUS_RECONCILATION_DONE);
        if(\request()->method() == Request::METHOD_POST){
            $items->whereIn('id',explode(',',\request()->claims));
        }
        $items = $items->get();
        $name = 'Reconciliation Result '.Carbon::now()->toDateString(). '.csv';

        return (new FastExcel($items))->download($name, function ($item) {
            return [
                'InvoiceNumber' => 'A'.$item->claim->id,
                'ProvClaimRef' => 'A'.$item->claim_reference,
                'ItemID' => $item->support_item_number,
                'ItemQty' => $item->hours,
                'UnitPrice' => $item->unit_price,
                'AmountClaimed' => $item->amount_claimed,
                'AmountPaid' => $item->amount_paid,
                'ParticipantNDIS' => $item->claim->participant->ndis_number,
                'ParticipantName' => $item->claim->participant->user->name,
                //'ParticipantLastName' => $item->claim->participant->user->name,
                'ProvName' => $item->claim->provider->user->name,
                'ProviderInvoiceRefNo' => $item->claim->claim_reference,
                'SupportStartDate' => $item->claim->start_date,
                'SupportEndDate' => $item->claim->end_date,
                //'ServiceBookingNum' => 'N/A',
                //'BulkClmId' => 'N/A',
                'FullyPaid' => $item->rec_is_full_paid,
                'ClaimType' => $item->claim_type,
                'CancelRsn' => $item->cancellation_reason,
            ];
        });
    }

    /**
     * @param Request $request
     */
    public function uploadReconciledFile(Request $request)
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('export_import_documents')) {
            return $this->respondForbidden();
        }
        $request->validate([
            'file' => 'required|file',
        ]);

        $ext = $request->file('file')->extension();
        $orgianlExt = $request->file('file')->getClientOriginalExtension();

        $rule = "required|file|mimes:csv,xls,xlsx,xlsb";
        if( $ext == 'txt' && $orgianlExt == 'csv'){
            $rule = "required|file|mimes:txt,csv,xls,xlsx,xlsb";
            //$filename = Str::random(15).".".$orgianlExt;
        }
        $request->validate(['file' => $rule]);
        $filename = Str::random(15) .".".$orgianlExt;
        try {
            $path = $request->file('file')->storeAs('reconciliations',$filename);
            $fullPath = Storage::path($path);
            $collection = (new FastExcel)->import($fullPath);
            $now = Carbon::now();
            if($collection->isNotEmpty())
            {
                foreach ($collection as $claim) {
                    $claimItem = ClaimLineItem::where('claim_reference', substr($claim['ClaimReference'],1) )->first();
                    if($claimItem){
                        $claimItem->amount_paid = is_numeric( $claim['PaidTotalAmount'] )? $claim['PaidTotalAmount'] : null;
                        $claimItem->rec_is_full_paid = abs($claimItem->amount_claimed - $claimItem->amount_paid) <= 1   ? true: false;
                        $claimItem->rec_payment_request_status = $claim['Payment Request Status'];
                        $claimItem->rec_payment_request_number = $claim['Payment Request Number'];
                        $claimItem->rec_capped_price = $claim['Capped Price'];
                        $claimItem->rec_date = $now;
                        $claimItem->status = Claim::STATUS_RECONCILATION_DONE;
                        $claimItem->save();
                    }
                }
            }


        } catch (IOException $e) {
            dd($e->getMessage());
        }
        catch (QueryException $e){
            dd($e->getMessage());
        }
        catch (Exception $e) {
            dd($e->getMessage());
        }

        return $this->respondWithSuccess();
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
