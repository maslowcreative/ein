<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimPostRequest;
use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Provider;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        foreach ($request->service as $item) {
            $item = array_merge($item,['status' => ClaimLineItem::STATUS_PENDING]);
            $claim->items()->create($item);
        }
        DB::commit();
        return $this->respondCreated();

    }

    public function approvedByRepresentative(Request $request,Claim $claim) {

        if(!Auth::user()->hasRole('representative')) {
            return $this->respondForbidden();
        }

        if($claim->status != Claim::STATUS_APPROVAL_PENDING ){
            return $this->respondForbidden();
        }

        $request->validate(['status'=> 'required',Rule::in([Claim::STATUS_APPROVED_BY_REPRESENTATIVE,Claim::STATUS_DENIED_BY_REPRESENTATIVE])]);

        $claim->status = $request->status;
        $claim->save();

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
