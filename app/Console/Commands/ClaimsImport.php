<?php

namespace App\Console\Commands;

use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Provider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClaimsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claims:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $claimIds = Claim::where('old_claim_id','<>',null)->get()->pluck('old_claim_id');
        $tempClaims = DB::table('temp_claims')->whereNull('status')
                                                    ->whereNotIn('old_claim_id',$claimIds)
                                                    ->get()
                                                    ->groupBy('old_claim_id');

        foreach ($tempClaims as $oldId => $claim){
            //if(!$claimObj) {
                $participant = Participant::where('user_id', $claim[0]->participant_system_id)->first();
                $provider = Provider::where('user_id', $claim[0]->provider_system_id)->first();
                $claimObj = new Claim();
                $claimObj->old_claim_id = $oldId;
                $claimObj->provider_id = $claim[0]->provider_system_id;
                $claimObj->participant_id = $claim[0]->participant_system_id;
                $claimObj->claim_reference = $claim[0]->claim_ref;
                $claimObj->invoice_path = '';
                $claimObj->ndis_number = $participant->ndis_number;
                $claimObj->start_date = $claim[0]->service_start_date;
                $claimObj->end_date = $claim[0]->service_end_date;
                $claimObj->provider_abn = $provider->abn;
                $claimObj->status = Claim::STATUS_RECONCILATION_DONE;
                $claimObj->created_at = $claim[0]->claim_date;
                $claimObj->save();
                foreach ($claim as $item) {
                    $claimItem = new ClaimLineItem();
                    $claimItem->claim_id = $claimObj->id;
                    $claimItem->provider_id = $claimObj->provider_id;
                    $claimItem->participant_id = $claimObj->participant_id;
                    $claimItem->claim_reference = $claimObj->id . '_' . explode('_', $item->old_claim_sr_no)[1];
                    $claimItem->old_claim_ref = $item->old_claim_sr_no;
                    $claimItem->support_item_number = $item->item_master_id;
                    $claimItem->hours = $item->unit_number;
                    $claimItem->unit_price = $item->unit_price;
                    $claimItem->amount_claimed = $item->claim_amount;
                    $claimItem->amount_paid = $item->received_amount;
                    $claimItem->gst_code = $item->gst;
                    $claimItem->claim_type = $item->claim_type;
                    $claimItem->claim_type = $item->claim_type;
                    $claimItem->status = Claim::STATUS_RECONCILATION_DONE;
                    $claimItem->rec_is_full_paid = 1;
                    $claimItem->save();
                }
            //}

        }
        return 0;
    }
}
