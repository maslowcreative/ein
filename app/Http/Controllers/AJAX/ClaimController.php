<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimPostRequest;
use App\Mail\InvoiceCreated;
use App\Mail\ProviderBudgetExceeded;
use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\Provider;
use App\Models\ProviderBudget;
use App\Models\Representative;
use App\Traits\ClaimsValidationTrait;
use Box\Spout\Common\Exception\IOException;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Collection;
use PHPUnit\Exception;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpFoundation\StreamedResponse;


class ClaimController extends Controller
{
    use ApiResponseHelpers,ClaimsValidationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('claim.service.clean')->only('store','storeAdmin');
    }

    public function index()
    {
        $claims = Claim::getClaims()->where('status','<>', Claim::STATUS_CANCEL);

        if(Auth::user()->hasRole('provider')) {
            $claims->where('provider_id',Auth::user()->id)
                   ->where('status','<>', Claim::STATUS_CANCEL);
        }

        if(Auth::user()->hasRole('representative')) {
            $claims->whereIn('participant_id',Auth::user()->representative->participants()->pluck('user_id'))
                    ->where('status','<>', Claim::STATUS_CANCEL) ;
        }

        return  $claims->paginate(5);
    }

    public function index2()
    {
        $claims = ClaimLineItem::getClaims();
        $claims->has('claim.provider.user')
                ->has('claim.participant.user');

        if(Auth::user()->hasRole('provider')) {
            $claims->where('provider_id',Auth::user()->id)
                ->where('status','<>', Claim::STATUS_CANCEL);
        }

        if(Auth::user()->hasRole('representative')) {
            $claims->whereIn('participant_id',Auth::user()->representative->participants()->pluck('user_id'))
                ->where('status','<>', Claim::STATUS_CANCEL);
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

        $planExist =  Plan::where('start_date','<=',$request->start_date)
                         ->where('end_date','>=',$request->end_date)
                         ->where('participant_id',$participant->id)
                         ->first();

       if(!$planExist){
           return response([
               'message' => "The given data was invalid.",
               'errors' => [
                   'start_date' => 'No plan exist in given date range',
                   'end_date' => 'No plan exist in given date range'
               ]
           ],422);
       }

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
            $claimItem = $claim->items()->create($item);

            $claimData = $this->claimPreValidate($claimItem);

            if(!$claimData['status']){
                DB::rollBack();

                $maxId = DB::table('claims')->max('id');
                DB::statement("ALTER TABLE claims AUTO_INCREMENT=$maxId");

                return $this->respondError($claimData['message']) ;
            }else
            {
                $catBudget = $claimData['catBudget'];

                $providerCatBudget = $claimData['providerCatBudget'];

                $catBudget->balance = $catBudget->balance - $claimItem->amount_claimed;
                $providerCatBudget->balance = $providerCatBudget->balance - $claimItem->amount_claimed;

                $catBudget->pending = $catBudget->pending + $claimItem->amount_claimed;
                $providerCatBudget->pending = $providerCatBudget->pending + $claimItem->amount_claimed;

                $catBudget->save();
                $providerCatBudget->save();

                $claimItem->plan_id = $catBudget->plan_id;
                $claimItem->category_id = $catBudget->category_id;
                $claimItem->save();
            }

        }
        DB::commit();
        // Sending Email for provider case
        if(!$isRepresentative && $participant){
            $toEmail = optional($participant->representative)->email;
            if($toEmail) {
                Mail::to($toEmail)
                    ->send(new InvoiceCreated($provider));
            }
        }
        //Sending Email for Rep
        elseif($isRepresentative && $participant){

            $toEmail = env('CLAIM_BCC_EMAIL','serviceprovider@ein.net.au');
            $repName = \auth()->user()->name;
            if($toEmail) {
                Mail::to($toEmail)
                    ->send(new InvoiceCreated($provider,'representative',$repName));
            }

        }

        return $this->respondCreated();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdmin(ClaimPostRequest $request)
    {
        $provider = null;
        if($request->action_role == 'provider'){
            $provider = Provider::findOrFail($request->provider_id);
        }

        $isRepresentative = false;
        $participant = Participant::findOrFail($request->participant_id);

        if(!$provider && $request->action_role == 'representative'){
            $representative =  Representative::find($participant->representative_id);
            if(!$representative){
                return $this->respondNotFound(__('record.not_found',['model'=>'Provider']));
            }
            $isRepresentative = true;
            $provider = Provider::find($request->provider_id);
        }

        $planExist =  Plan::where('start_date','<=',$request->start_date)
                            ->where('end_date','>=',$request->end_date)
                            ->where('participant_id',$participant->id)
                            ->first();

        if(!$planExist){
            return response([
                'message' => "The given data was invalid.",
                'errors' => [
                    'start_date' => 'No plan exist in given date range',
                    'end_date' => 'No plan exist in given date range'
                ]
            ],422);
        }

        DB::beginTransaction();

        $path = $request->file('file')->store('claims');

        $claim = $provider->claims()->create(
            array_merge($request->all(),[
                'ndis_number' => $participant->ndis_number,
                'provider_abn' => $isRepresentative ? 'REIMB' : $provider->abn ,
                'status' =>  $isRepresentative ? Claim::STATUS_APPROVED_BY_REPRESENTATIVE : Claim::STATUS_APPROVAL_PENDING,
                'invoice_path' => $path,
                'admin_id' => \auth()->user()->id
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
            $claimItem =  $claim->items()->create($item);

            $claimData = $this->claimPreValidate($claimItem);

            if(!$claimData['status']){
                DB::rollBack();

                $maxId = DB::table('claims')->max('id');
                DB::statement("ALTER TABLE claims AUTO_INCREMENT=$maxId");

                return $this->respondError($claimData['message']) ;
            }else
            {
                $catBudget = $claimData['catBudget'];

                $providerCatBudget = $claimData['providerCatBudget'];

                $catBudget->balance = $catBudget->balance - $claimItem->amount_claimed;
                $providerCatBudget->balance = $providerCatBudget->balance - $claimItem->amount_claimed;

                $catBudget->pending = $catBudget->pending + $claimItem->amount_claimed;
                $providerCatBudget->pending = $providerCatBudget->pending + $claimItem->amount_claimed;

                $catBudget->save();
                $providerCatBudget->save();

                $claimItem->plan_id = $catBudget->plan_id;
                $claimItem->category_id = $catBudget->category_id;
                $claimItem->save();
            }
        }


        DB::commit();

        if(!$isRepresentative && $participant){
            $toEmail = optional($participant->representative)->email;
            if($toEmail) {
                Mail::to($toEmail)
                    ->send(new InvoiceCreated($provider,'admin'));
            }
        }

        return $this->respondCreated();

    }

    public function approvedByRepresentative(Request $request,ClaimLineItem $claim) {

        if(!Auth::user()->hasRole('representative')) {
            return $this->respondForbidden();
        }

        if(!in_array($claim->status, [Claim::STATUS_APPROVAL_PENDING,Claim::STATUS_APPROVED_BY_REPRESENTATIVE, Claim::STATUS_DENIED_BY_REPRESENTATIVE])){
            return $this->respondForbidden();
        }

        $request->validate(['status'=> 'required',Rule::in([Claim::STATUS_APPROVED_BY_REPRESENTATIVE,Claim::STATUS_DENIED_BY_REPRESENTATIVE])]);

        if($request->status == $claim->status ){
            return $this->respondError('Cannot select same option twice.');
        }

        $claim->status = $request->status;

        //Approve by Representative
        if($request->status == Claim::STATUS_APPROVED_BY_REPRESENTATIVE){

            if($claim->plan_id)
            {
                $claimData = $this->claimValidateNew($claim,[
                    'plan_id' => $claim->plan_id,
                    'category_id' => $claim->category_id,
                ]);

                if(!$claimData['status']){
                    return $this->respondError($claimData['message']) ;
                }
                $claim->save();
            }
            else
            {
                //OLD
                $claimData = $this->claimValidateNew($claim);

                if(!$claimData['status']){
                    return $this->respondError($claimData['message']) ;
                }

                //Cleared ProvCat
                DB::transaction(function () use ($claim,$claimData) {
                    $catBudget = $claimData['catBudget'];
                    $providerCatBudget = $claimData['providerCatBudget'];

                    $catBudget->balance = $catBudget->balance - $claim->amount_claimed;
                    $providerCatBudget->balance = $providerCatBudget->balance - $claim->amount_claimed;

                    $catBudget->pending = $catBudget->pending + $claim->amount_claimed;
                    $providerCatBudget->pending = $providerCatBudget->pending + $claim->amount_claimed;

                    $catBudget->save();
                    $providerCatBudget->save();

                    $claim->plan_id = $catBudget->plan_id;
                    $claim->category_id = $catBudget->category_id;
                    $claim->save();
                });
            }

        }
        elseif ($request->status == Claim::STATUS_DENIED_BY_REPRESENTATIVE)
        {
            $catBudget =  PlanBudget::where('plan_id',$claim->plan_id)
                                    ->where('category_id',$claim->category_id)
                                    ->first();

            $providerCatBudget = null;
            if($catBudget){
                $providerCatBudget = ProviderBudget::where('category_id',$catBudget->category_id)
                                                    ->where('plan_id',$catBudget->plan_id)
                                                    ->where('plan_budget_id',$catBudget->id)
                                                    ->where('provider_id',$claim->provider_id)
                                                    ->first();
            }
            //Cleared ProvCat
            if($catBudget){
                $catBudget->pending = $catBudget->pending - $claim->amount_claimed;
                $catBudget->balance = $catBudget->balance +  $claim->amount_claimed;
            }

            if($providerCatBudget){
                $providerCatBudget->pending = $providerCatBudget->pending - $claim->amount_claimed;
                $providerCatBudget->balance = $providerCatBudget->balance +  $claim->amount_claimed;
            }

            $claim->plan_id = null;
            $claim->category_id = null;

            DB::transaction(function () use ($claim,$catBudget,$providerCatBudget){
                $claim->save();
                if($catBudget)
                {
                    $catBudget->save();
                }
                if($providerCatBudget)
                {
                    $providerCatBudget->save();
                }

            });

        }
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
                'ClaimType' => $item->claim_type_proccesed,
                'CancellationReason' => $item->cancellation_reason,
                'ABN of Support Provider' => $item->claim->provider_abn,
                'ServiceBookingNumber' => null
            ];
        });
    }

    public function quickReconciliation()
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('export_import_documents')) {
            return $this->respondForbidden();
        }

        $items = ClaimLineItem::with('claim')->orderBy('id','desc');
        if(\request()->method() == Request::METHOD_POST){
            $items->whereIn('id',explode(',',\request()->claims));
        }
        $itemsUpdate = $items;

        $items = $items->take(10000)->get();

        //$itemsUpdate->update(['status' => Claim::STATUS_PROCESSED]);

        $name = Carbon::now()->format('YmdHi'). '.csv';

            return (new FastExcel($items))->download($name, function ($item) {
            return [
                'RegistrationNumber' => env('EIN_REGISTRATION_NUMBER','N/A'),
                'NdisNumber' => (string) $item->claim->ndis_number,
                'SupportDeliveredFrom' => Carbon::create($item->claim->start_date)->format('Y-m-d'),
                'SupportsDeliveredTo' => Carbon::create($item->claim->end_date)->format('Y-m-d'),
                'SupportNumber' => $item->support_item_number,
                'ClaimReference' => 'A'.$item->claim_reference,
                'Status' => Claim::STATS[$item->status],
                'Quantity' => $item->hours,
                'Hours' => null,
                'UnitPrice' => $item->unit_price,
                'GstCode' => $item->gst_code,
                'AuthorisedBy' => '',
                'ParticipantApproved' => '',
                'GstCode' => $item->gst_code,
                'InKindFundingProgram' => '',
                'ClaimType' => $item->claim_type_proccesed,
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
    public function reconciledResultsFileOLD()
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
                'ParticipantNDIS' => optional($item->claim->participant)->ndis_number,
                'ParticipantFirstName' => optional(optional($item->claim->participant)->user)->first_name,
                'ParticipantLastName' => optional(optional($item->claim->participant)->user)->last_name,
                'ProvName' => optional(optional($item->claim->provider)->user)->other_name,
                'ProviderInvoiceRefNo' => $item->claim->claim_reference,
                'SupportStartDate' => $item->claim->start_date,
                'SupportEndDate' => $item->claim->end_date,
                'FullyPaid' => $item->rec_is_full_paid,
                'ClaimType' => $item->claim_type_proccesed,
                'CancelRsn' => $item->cancellation_reason,
            ];
        });
    }

    public function reconciledResultsFile()
    {
        if(!Auth::user()->hasRole('admin') && !Auth::user()->hasPermissionTo('export_import_documents')) {
            return $this->respondForbidden();
        }

        $itemsQuery = ClaimLineItem::with('claim', 'claim.provider.user', 'claim.participant.user')
            ->where('status', Claim::STATUS_RECONCILATION_DONE);

        if (\request()->method() == Request::METHOD_POST) {
            $itemsQuery->whereIn('id', explode(',', \request()->claims));
        }

        $name = 'Reconciliation Result ' . Carbon::now()->toDateString() . '.csv';

        $response = new  StreamedResponse(function() use ($itemsQuery) {
            $handle = fopen('php://output', 'w');

            // Add the CSV headers
            fputcsv($handle, [
                'InvoiceNumber', 'ProvClaimRef', 'ItemID', 'ItemQty', 'UnitPrice', 'AmountClaimed', 'AmountPaid',
                'ParticipantNDIS', 'ParticipantFirstName', 'ParticipantLastName', 'ProvName', 'ProviderInvoiceRefNo',
                'SupportStartDate', 'SupportEndDate', 'FullyPaid', 'ClaimType', 'CancelRsn'
            ]);

            // Fetch and process the data in chunks
            $itemsQuery->chunk(100, function($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        'InvoiceNumber' => 'A' . $item->claim->id,
                        'ProvClaimRef' => 'A' . $item->claim_reference,
                        'ItemID' => $item->support_item_number,
                        'ItemQty' => $item->hours,
                        'UnitPrice' => $item->unit_price,
                        'AmountClaimed' => $item->amount_claimed,
                        'AmountPaid' => $item->amount_paid,
                        'ParticipantNDIS' => optional($item->claim->participant)->ndis_number,
                        'ParticipantFirstName' => optional(optional($item->claim->participant)->user)->first_name,
                        'ParticipantLastName' => optional(optional($item->claim->participant)->user)->last_name,
                        'ProvName' => optional(optional($item->claim->provider)->user)->other_name,
                        'ProviderInvoiceRefNo' => $item->claim->claim_reference,
                        'SupportStartDate' => $item->claim->start_date,
                        'SupportEndDate' => $item->claim->end_date,
                        'FullyPaid' => $item->rec_is_full_paid,
                        'ClaimType' => $item->claim_type_proccesed,
                        'CancelRsn' => $item->cancellation_reason,
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $name . '"');

        return $response;
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

            $emailsData = [];
            if($collection->isNotEmpty())
            {
                foreach ($collection as $claim) {
                    $claimItem = ClaimLineItem::where('claim_reference', substr($claim['ClaimReference'],1) )
                                                ->where('status',Claim::STATUS_PROCESSED)
                                                ->first();
                    $paidAmount = 0;
                    if( trim($claim['Payment Request Status']) == 'SUCCESSFUL'){
                        $paidAmount = is_numeric( $claim['PaidTotalAmount'] )? $claim['PaidTotalAmount'] : 0;
                    }

                    if($claimItem){

                        $claimItem->amount_paid = $paidAmount;
                        $claimItem->rec_is_full_paid = abs($claimItem->amount_claimed - $claimItem->amount_paid) <= 1   ? true: false;
                        $claimItem->rec_payment_request_status = $claim['Payment Request Status'];
                        $claimItem->rec_payment_request_number = $claim['Payment Request Number'];
                        $claimItem->rec_capped_price = $claim['Capped Price'];
                        $claimItem->rec_date = $now;
                        $claimItem->status = Claim::STATUS_RECONCILATION_DONE;
                        $claimItem->save();

                        //Category Budget Clearing
                        $catBudget = PlanBudget::where('plan_id',$claimItem->plan_id)
                            ->where('category_id',$claimItem->category_id)
                            ->first();

                        if($catBudget && $claimItem->rec_payment_request_status == 'SUCCESSFUL' && $claimItem->rec_is_full_paid)
                        {
                            $catBudget->pending = $catBudget->pending - $claimItem->amount_claimed;
                            $catBudget->spent = $catBudget->spent + $claimItem->amount_claimed;

                        }elseif ($catBudget && $claimItem->rec_payment_request_status == 'SUCCESSFUL' && !$claimItem->rec_is_full_paid)
                        {
                            $catBudget->pending = $catBudget->pending - $claimItem->amount_claimed;
                            $catBudget->balance = ($catBudget->balance + $claimItem->amount_claimed) - $claimItem->amount_paid;
                            $catBudget->spent = $catBudget->spent + $claimItem->amount_paid;

                        }elseif($catBudget)
                        {
                            $catBudget->pending = $catBudget->pending - $claimItem->amount_claimed;
                            $catBudget->balance = $catBudget->balance + $claimItem->amount_claimed;
                        }

                        if($catBudget){
                            $catBudget->save();
                        }
                        //Cleared ProvCat
                        //Provider Category Budget Clearing
                        $providerCatBudget = null;
                        if($catBudget){
                            $providerCatBudget = ProviderBudget::where('category_id',$catBudget->category_id)
                                                                ->where('plan_id',$catBudget->plan_id)
                                                                ->where('plan_budget_id',$catBudget->id)
                                                                ->where('provider_id',$claimItem->provider_id)
                                                                ->first();
                        }

                        if($providerCatBudget && $claimItem->rec_payment_request_status == 'SUCCESSFUL' && $claimItem->rec_is_full_paid)
                        {
                            $providerCatBudget->pending = $providerCatBudget->pending - $claimItem->amount_claimed;
                            $providerCatBudget->spent = $providerCatBudget->spent + $claimItem->amount_claimed;

                        }elseif ($providerCatBudget && $claimItem->rec_payment_request_status == 'SUCCESSFUL' && !$claimItem->rec_is_full_paid)
                        {
                            $providerCatBudget->pending = $providerCatBudget->pending - $claimItem->amount_claimed;
                            $providerCatBudget->balance = ($providerCatBudget->balance + $claimItem->amount_claimed) - $claimItem->amount_paid;
                            $providerCatBudget->spent = $providerCatBudget->spent + $claimItem->amount_paid;

                        }elseif($providerCatBudget)
                        {
                            $providerCatBudget->pending = $providerCatBudget->pending - $claimItem->amount_claimed;
                            $providerCatBudget->balance = $providerCatBudget->balance + $claimItem->amount_claimed;
                        }

                        if($providerCatBudget){
                            $providerCatBudget->save();
                            $percentage = ($providerCatBudget->spent / $providerCatBudget->amount) * 100;
                            if($percentage>= 80)
                            {
                                $data = [
                                    'participant_id' => $claimItem->participant_id,
                                    'percentage_exceeded' => $percentage,
                                    'providerCatBudget' =>$providerCatBudget
                                ];
                                Mail::to(env('EIN_ADMIN_EMAIL'))
                                    ->send(new ProviderBudgetExceeded($data));
                            }
                        }
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

    public function updateClaim(Request $request)
    {
        $request->validate([
            'claim_type' => ['nullable','string',Rule::in(collect(Claim::CLAIM_TYPES)->keys()->toArray())],
            'cancellation_reason' => ['exclude_unless:claim_type,CANC','required',Rule::in(collect(Claim::CANCELLATION_REASONS)->keys()->toArray())],
            'hours' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0.1',
            'gst_code' => ['required',Rule::in(collect(Claim::TAX_TYPES)->keys()->toArray())],
            'status' => ['required',Rule::in([
                                                Claim::STATUS_APPROVAL_PENDING,
                                                Claim::STATUS_APPROVED_BY_REPRESENTATIVE,
                                                Claim::STATUS_DENIED_BY_REPRESENTATIVE,
                                                Claim::STATUS_APPROVED_BY_ADMIN,
                                                Claim::STATUS_PROCESSED,
                                                Claim::STATUS_RECONCILATION_DONE,
                                                Claim::STATUS_CANCEL
                                            ])],

        ]);

        $claim = ClaimLineItem::findOrFail($request->id);
        $status = $request->status;
        $request->merge(['amount_claimed' => $request->hours * $request->unit_price]);
        $claim->fill($request->all());

        if($claim->getOriginal('status') <> Claim::STATUS_RECONCILATION_DONE && $status == Claim::STATUS_RECONCILATION_DONE){
            return $this->respondError('This state cannot be selected.') ;
        }

        $isReconcilled = false;
        if($claim->getOriginal('status') == Claim::STATUS_RECONCILATION_DONE && $status <> Claim::STATUS_RECONCILATION_DONE )
        {
            $isReconcilled = true;
        }

        if($status == Claim::STATUS_DENIED_BY_REPRESENTATIVE || $status == Claim::STATUS_CANCEL)
        {
            $catBudget =  PlanBudget::where('plan_id',$claim->plan_id)
                ->where('category_id',$claim->category_id)
                ->first();

            if($catBudget && !$isReconcilled){
                $catBudget->pending = $catBudget->pending - $claim->amount_claimed;
                $catBudget->balance = $catBudget->balance +  $claim->amount_claimed;
            }
            elseif ($catBudget && $isReconcilled)
            {
                if($claim->rec_payment_request_status == 'SUCCESSFUL')
                {
                    $catBudget->spent = $catBudget->spent - $claim->amount_claimed;
                    $catBudget->balance = $catBudget->balance +  $claim->amount_claimed;
                }
            }

            //Cleared ProvCat
            $providerCatBudget = null;
            if($catBudget){
                $providerCatBudget = ProviderBudget::where('category_id',$catBudget->category_id)
                                                    ->where('plan_id',$catBudget->plan_id)
                                                    ->where('plan_budget_id',$catBudget->id)
                                                    ->where('provider_id',$claim->provider_id)
                                                    ->first();
            }

            if($providerCatBudget && !$isReconcilled){
                $providerCatBudget->pending = $providerCatBudget->pending - $claim->amount_claimed;
                $providerCatBudget->balance = $providerCatBudget->balance +  $claim->amount_claimed;
            }
            elseif ($providerCatBudget && $isReconcilled)
            {
                if($claim->rec_payment_request_status == 'SUCCESSFUL')
                {
                    $providerCatBudget->spent = $providerCatBudget->spent - $claim->amount_claimed;
                    $providerCatBudget->balance = $providerCatBudget->balance +  $claim->amount_claimed;
                }
            }

            if($isReconcilled)
            {
                $claim->amount_paid = null;
                $claim->rec_is_full_paid = null;
                $claim->rec_payment_request_status = null;
                $claim->rec_payment_request_number = null;
                $claim->rec_capped_price = null;
                $claim->rec_date = null;
            }

            $claim->plan_id = null;
            $claim->category_id = null;
            $var = DB::transaction(function () use ($claim,$catBudget,$providerCatBudget){
                $claim->save();

                if($catBudget){
                    $catBudget->save();
                }

                if($providerCatBudget){
                    $providerCatBudget->save();
                }

            });
        }
        else
        {
            if($claim->plan_id)
            {
                $claimData = $this->claimValidateNew($claim,[
                    'plan_id' => $claim->plan_id,
                    'category_id' => $claim->category_id,
                ]);
            }
            //By Approve by Admin
            else
            {
                $claimData = $this->claimValidateNew($claim);
            }

            if(!$claimData['status']){
                return $this->respondError($claimData['message']) ;
            }
            $var = DB::transaction(function () use ($claim,$claimData) {
                $catBudget = $claimData['catBudget'];
                $providerCatBudget = $claimData['providerCatBudget'];

                if($claim->plan_id  && $claim->isDirty('amount_claimed'))
                {
                    //Cleared ProvCat
                    $catBudget->balance = $catBudget->balance + $claim->getOriginal('amount_claimed');
                    $providerCatBudget->balance = $providerCatBudget->balance + $claim->getOriginal('amount_claimed');

                    $catBudget->pending = $catBudget->pending - $claim->getOriginal('amount_claimed');
                    $providerCatBudget->pending = $providerCatBudget->pending - $claim->getOriginal('amount_claimed');

                    $catBudget->balance = $catBudget->balance - $claim->amount_claimed;
                    $providerCatBudget->balance = $providerCatBudget->balance - $claim->amount_claimed;

                    $catBudget->pending = $catBudget->pending + $claim->amount_claimed;
                    $providerCatBudget->pending = $providerCatBudget->pending + $claim->amount_claimed;

                    $catBudget->save();
                    $providerCatBudget->save();

                    $claim->save();
                }
                elseif($claim->plan_id && !$claim->isDirty('amount_claimed'))
                {
                    $claim->save();
                }
                else
                {
                    if($claim->getOriginal('status') != Claim::STATUS_RECONCILATION_DONE)
                    {
                        //Cleared ProvCat
                        $catBudget->balance = $catBudget->balance - $claim->amount_claimed;
                        $providerCatBudget->balance = $providerCatBudget->balance - $claim->amount_claimed;


                        $catBudget->pending = $catBudget->pending + $claim->amount_claimed;
                        $providerCatBudget->pending = $providerCatBudget->pending + $claim->amount_claimed;

                        $catBudget->save();
                        $providerCatBudget->save();

                        $claim->plan_id = $catBudget->plan_id;
                        $claim->category_id = $catBudget->category_id;
                    }

                    $claim->save();
                }
            });
        }

        return $this->respondOk('Claim updated.');
    }
}
