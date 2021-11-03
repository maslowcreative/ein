<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimPostRequest;
use App\Models\Participant;
use App\Models\Provider;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaimPostRequest $request)
    {
        $provider = optional(\auth()->user())->provider;
        if(!$provider){
            return $this->respondNotFound(__('record.not_found',['model'=>'Provider']));
        }

        $participant = Participant::find($request->participant_id);

        DB::beginTransaction();
        $claim = $provider->claims()->create(
            array_merge($request->all(),['ndis_number' => $participant->ndis_number])
        );
        foreach ($request->service as $item) {
            $claim->items()->create($item);
        }
        DB::commit();
        return $this->respondCreated();

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
