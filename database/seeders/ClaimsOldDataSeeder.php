<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Participant;
use App\Models\Provider;
use Box\Spout\Common\Exception\IOException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ClaimsOldDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $basePath = Storage::path('data');

            $services = (new FastExcel())->import("{$basePath}/ItemMaster 2019-20 MAR25.xlsx")
                                       ->pluck('Item_Number','ID');
            $collection = (new FastExcel())->import("{$basePath}/ClaimMaster.xlsx");

        }catch (IOException $e){
            $collection = [];
        }
        $providersMap = Provider::select('old_id','user_id','abn')
                                ->whereIn('old_id',$collection->pluck('ProviderMaster_ID'))
                                ->get()
                                ->groupBy('old_id')
                                ->toArray();

        $participantsMap = Participant::select('old_id','user_id','ndis_number')
                                        ->whereIn('old_id',$collection->pluck('ParticipantMaster_ID'))
                                        ->get()
                                        ->groupBy('old_id')
                                        ->toArray();

        foreach ($collection as $item) {

            if(!$item['Claim_Number']
               || !isset($providersMap[$item['ProviderMaster_ID']])
               || !isset($participantsMap[$item['ParticipantMaster_ID']])
              ) {
                continue;
            }
            $claimNumer = explode('_' ,$item['Claim_Number']);

            if( (int) $claimNumer[0] == 0 ){
                continue;
            }

            $claimNumer = explode('_' ,$item['Claim_Number']);

            $provider = $providersMap[$item['ProviderMaster_ID']][0];
            $participant = $participantsMap[$item['ParticipantMaster_ID']][0];

            $claim = Claim::updateOrCreate(
                [
                    'id' => $claimNumer[0]
                ],
                [
                    'claim_reference' => $item['Claim_Ref'],
                    'provider_id' => $provider['user_id'],
                    'participant_id' => $participant['user_id'],
                    'invoice_path' => '',
                    'ndis_number' => $participant['ndis_number'],
                    'start_date' => $item['Service_StartDate']  != ''?  $item['Service_StartDate']->format('Y-m-d') : null,
                    'end_date' => $item['Service_EndDate']  != ''?  $item['Service_EndDate']->format('Y-m-d') : null,
                    'status' => Claim::STATUS_RECONCILATION_DONE,
                ]
            );

            $claim_ref = $item['Claim_Number'];

            if(count($claimNumer) == 1)
            {
                $claim_ref = $claim_ref.'_1';
            }

            ClaimLineItem::updateOrCreate(
               [ 'claim_reference' => $claim_ref , 'claim_id' => $claim->id],
               [
                   'provider_id' => $provider['user_id'],
                   'participant_id' => $participant['user_id'],
                   'support_item_number' => isset($services[$item['ItemMaster_ID']]) ? $services[$item['ItemMaster_ID']] : '',
                   'hours' => $item['Unit_Number'],
                   'unit_price' =>  $item['Unit_Price'],
                   'amount_claimed' => $item['Claim_Amount'],
                   'amount_paid' => $item['Received_Amount'],
                   'claim_type' => null,
                   'rec_is_full_paid' => true,
                   'rec_date' => $item['Claim_UploadDate']  != '' ? $item['Claim_UploadDate']->format('Y-m-d') : null,
                   'status' => Claim::STATUS_RECONCILATION_DONE,
               ]
            );
        }

    }
}
