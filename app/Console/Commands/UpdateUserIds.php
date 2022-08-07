<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUserIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claim:update-userid';

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
        $providers = DB::table('temp_user')->where('type','provider')->get();

        foreach ($providers as $provider){
            DB::table('temp_claims')->where('provider_master_id',$provider->sheet_name)->update(['provider_system_id' => $provider->user_id]);
        }


        $participants = DB::table('temp_user')->where('type','participant')->get();

        foreach ($participants as $participant){
            DB::table('temp_claims')->where('participant_master_id',$participant->sheet_name)->update(['participant_system_id' => $participant->user_id]);
        }

        //Claims With 0;
        $refs = DB::table('temp_claims')->where('old_claim_id',0)->get()->pluck('claim_ref');
        DB::table('temp_claims')->whereIn('claim_ref',$refs)->update(['status' =>'zero_error']);

        DB::table('temp_claims')->where('participant_system_id',null)->orWhere('provider_system_id',null)->update(['status' =>'user_mismatch']);

        DB::table('temp_claims')->where('claim_amount','NO')->update(['status' =>'no_pay']);
        DB::table('temp_claims')->where('unit_number','-')->update(['status' =>'unit_dash']);
        DB::table('temp_claims')->where('received_amount','PAY')->update(['status' =>'pay_donot']);
        DB::table('temp_claims')->where('paid_date','NO PAY')->update(['status' =>'no_pay']);
        DB::table('temp_claims')->where('claim_date','CANCELLED')->update(['status' =>'CANCELLED']);

        $temClaims = DB::table('temp_claims')->whereNull('status','')->get();

        foreach ($temClaims as $claim){

            $service_start_date = $claim->service_start_date;
            $service_end_date = $claim->service_end_date;
            $claim_date = $claim->claim_date;
            $paid_date = $claim->paid_date;

            if(count(explode('-',$claim->service_start_date)) > 1)
            {
                $service_start_date = explode('-',$claim->service_start_date);
                $service_start_date = $service_start_date[0].'-'.$service_start_date[1].'-'.$service_start_date[2];

            }elseif(count(explode('/',$claim->service_start_date)) > 1){

                $service_start_date = explode('/',$claim->service_start_date);
                $service_start_date = $service_start_date[2].'-'.$service_start_date[1].'-'.$service_start_date[0];
            }

            if(count(explode('-',$claim->service_end_date)) > 1)
            {
                $service_end_date = explode('-',$claim->service_end_date);
                $service_end_date = $service_end_date[0].'-'.$service_end_date[1].'-'.$service_end_date[2];

            }elseif(count(explode('/',$claim->service_end_date)) > 1){

                $service_end_date = explode('/',$claim->service_end_date);
                $service_end_date = $service_end_date[2].'-'.$service_end_date[1].'-'.$service_end_date[0];
            }

            if(count(explode('-',$claim->claim_date)) > 1)
            {
                $claim_date= explode('-',$claim->claim_date);
                $claim_date = $claim_date[0].'-'.$claim_date[1].'-'.$claim_date[2];

            }elseif(count(explode('/',$claim->claim_date)) > 1){

                $claim_date = explode('/',$claim->claim_date);
                $claim_date = $claim_date[2].'-'.$claim_date[1].'-'.$claim_date[0];
            }


            if(count(explode('-',$claim->paid_date)) > 1)
            {
                $paid_date= explode('-',$claim->paid_date);
                $paid_date = $paid_date[0].'-'.$paid_date[1].'-'.$paid_date[2];

            }elseif(count(explode('/',$claim->paid_date)) > 1){

                $paid_date = explode('/',$claim->paid_date);
                $paid_date = $paid_date[2].'-'.$paid_date[1].'-'.$paid_date[0];
            }

            DB::table('temp_claims')->where('id',$claim->id)
                ->update([
                        'service_start_date' => $service_start_date,
                        'service_end_date' => $service_end_date,
                        'claim_date' => $claim_date,
                        'paid_date' => $paid_date,
                     ]);


        }

        $temClaims = DB::table('temp_claims')->whereNull('status','')->get();
        foreach ($temClaims as $claim){
            DB::table('temp_claims')->where('id',$claim->id)
                ->update([
                    'service_start_date' => trim(str_replace("00:00:00","",$claim->service_start_date)),
                    'service_end_date' => trim(str_replace("00:00:00","",$claim->service_end_date)),
                    'claim_date' => trim(str_replace("00:00:00","",$claim->claim_date)),
                    'paid_date' => trim(str_replace("00:00:00","",$claim->paid_date)),
                ]);

        }



    }
}
