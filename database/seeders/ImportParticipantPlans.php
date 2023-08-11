<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Plan;
use App\Models\PlanBudget;
use Box\Spout\Common\Exception\IOException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportParticipantPlans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->truncate();
        DB::table('plan_budget')->truncate();

        try {
            $basePath = Storage::path('data');
            $collection = (new FastExcel())->sheet(3)->import("{$basePath}/MasterTables.xlsx");

            foreach ($collection as $item){
                if($item['TOTAL'] != '' || $item['TOTAL'] != null){
                    $participant = Participant::where('sr_no',$item['ID'])->first();

                    if(!$participant){
                        continue;
                    }

                    if($item['Plan Start'] instanceof \DateTime){
                        $planStart = $item['Plan Start'];
                    }else {
                        $planStart = explode( '/',$item['Plan Start']);
                        $planStart = $planStart[2] .'-'. $planStart[1]. '-'.$planStart[0];
                    }

                    if($item['Plan End'] instanceof \DateTime){
                        $planEnd = $item['Plan End'];
                    }else {
                        $planEnd = explode( '/',$item['Plan End']);
                        $planEnd = $planEnd[2] .'-'. $planEnd[1]. '-'.$planEnd[0];
                    }

                    $plan = Plan::create(
                        [
                            'participant_id' => $participant->user_id,
                            'start_date' => $planStart,
                            'end_date' => $planEnd,
                            'budget' => $item['TOTAL']
                        ]
                    );

                    for ($i = 1; $i <= 15 ; $i++ ){
                        if($item[$i] == '' || $item[$i] == null){
                            continue;
                        }
                       PlanBudget::create([
                            'plan_id' => $plan->id,
                            'category_id' => $i,
                            'amount' => $item[$i],
                        ]);

                    }
                }

            }
        }catch (IOException $e){
            $collection = [];
        }
    }
}
