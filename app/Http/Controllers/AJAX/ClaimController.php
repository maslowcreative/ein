<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimPostRequest;
use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Provider;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

        return  $claims->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store()
    public function store(ClaimPostRequest $request)
    {
        $provider = optional(\auth()->user())->provider;
        if(!$provider){
            return $this->respondNotFound(__('record.not_found',['model'=>'Provider']));
        }

        $participant = Participant::find($request->participant_id);

        DB::beginTransaction();

        $path = $request->file('file')->store('claims');
        $claim = $provider->claims()->create(
            array_merge($request->all(),[
                'ndis_number' => $participant->ndis_number,
                'provider_abn' => $provider->abn ,
                'status' => Claim::STATUS_APPROVAL_PENDING,
                'invoice_path' => $path
            ])
        );
        foreach ($request->service as $index => $item) {
            $key = $index + 1;
            $item = array_merge($item,[
                'status' => ClaimLineItem::STATUS_PENDING,
                'claim_reference' => "{$claim->claim_reference}_{$key}",
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

    public function bulkUploadFile()
    {
        if(!Auth::user()->hasRole('admin')) {
            return $this->respondForbidden();
        }

        $items = ClaimLineItem::with('claim')->where('status',Claim::STATUS_APPROVED_BY_REPRESENTATIVE);

        if(\request()->method() == Request::METHOD_POST){
            $items->whereIn('id',explode(',',\request()->claims));
        }

        $items = $items->get();

        $name = 'claims '.Carbon::now()->toDateString(). '.csv';
        return (new FastExcel($items))->download($name, function ($item) {
            return [
                'RegistrationNumber' => $item->claim->provider_id,
                'NdisNumber' => (string) $item->claim->ndis_number,
                'SupportDeliveredFrom' => Carbon::create($item->claim->start_date)->format('Y-m-d'),
                'SupportsDeliveredTo' => Carbon::create($item->claim->end_date)->format('Y-m-d'),
                'SupportNumber' => $item->support_item_number,
                'ClaimReference' => $item->claim_reference,
                'Quantity' => '',
                'Hours' => $item->hours,
                'UnitPrice' => $item->unit_price,
                'GstCode' => $item->gst_code,
                'AuthorisedBy' => '',
                'ParticipantApproved' => '',
                'GstCode' => $item->gst_code,
                'InKindFundingProgram' => '',
                'ClaimType' => $item->claim_type,
                'CancellationReason' => '',
                'ABN of Support Provider' => '',
            ];
        });
            //->sendHeaders(['X-Header-filename'=>$name]);
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
