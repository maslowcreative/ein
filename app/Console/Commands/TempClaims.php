<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class TempClaims extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claim:temp';

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
        try {
            $basePath = Storage::path('data');
            DB::table('temp_claims')->truncate();

            $collection = (new FastExcel())->import("{$basePath}/New All Claims Sheet.xlsx");
            $claims = $collection->sortBy('Claim_Number');

            foreach ($claims as $claim){

                DB::table('temp_claims')->insert([
                   [
                       'old_claim_id' => explode('_',$claim['Claim_Number'])[0],
                       'old_claim_sr_no' => $claim['Claim_Number'],
                       'claim_ref' => $claim['Claim_Ref'],
                       'provider_master_id' =>  trim($claim['ProviderMaster_ID']),
                       //'provider_system_id' => '',
                       'participant_master_id' => trim($claim['ParticipantMaster_ID']),
                       //'participant_system_id' => '',
                       'item_master_id' => $claim['ItemMaster_ID'],
                       'service_start_date' => $claim['Service_StartDate'],
                       'service_end_date' => $claim['Service_EndDate'],
                       'unit_number' =>  $claim['Unit_Number'],
                       'unit_price' => $claim['Unit_Price'],
                       'gst' => $claim['GST'],
                       'claim_amount' => $claim['Claim_Amount'],
                       'received_amount' => $claim['Received_Amount'],
                       'paid_date' => $claim['Paid_Date'],
                       'claim_date' => $claim['Claim_Date'],
                       'claim_type' => $claim['ClaimType'],

                   ]
                ]);
            }



        }catch (IOException $e){
            $collection = [];
        }
    }
}
