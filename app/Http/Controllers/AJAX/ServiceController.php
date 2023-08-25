<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Models\ParticipantItems;
use App\Models\ProviderItems;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items =  Service::getServices()
                         ->where('is_deleted',0)
                        ->select('support_item_number','support_item_name','reg_group_number','reg_group_name','support_category_number','support_category_name',
                            'ACT',
                            'NSW',
                            'NT',
                            'QLD',
                            'SA',
                            'TAS',
                            'VIC',
                            'WA'

                        );

        if(Auth::user()->hasRole('provider')) {
            \request()->validate([
                'participant_id' => 'required|integer'
            ]);

            $participantItems = ParticipantItems::where('participant_id',\request()->participant_id)->pluck('item_number');

            $providerItems = Auth::user()->provider->items()->whereIn('item_number',$participantItems)->pluck('item_number');

            $items = $items->whereIn('support_item_number',$providerItems);
        }

        if(Auth::user()->hasRole('representative') || \request()->is_admin) {

            \request()->validate([
                'participant_id' => 'required|integer',
                'provider_id' => 'required|integer',
            ]);

            $participantItems = ParticipantItems::where('participant_id',\request()->participant_id)->pluck('item_number');

            $providerItems = ProviderItems::where('provider_id',\request()->provider_id)
                ->whereIn('item_number',$participantItems)
                ->pluck('item_number');
            $items = $items->whereIn('support_item_number',$providerItems);
        }

        return $items->paginate(100);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
