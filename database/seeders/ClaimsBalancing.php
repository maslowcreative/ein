<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimsBalancing extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $claimItems = DB::table('claim_line_items  as cli')
            ->select('cli.id','cli.participant_id','c.start_date','c.end_date','cli.amount_claimed','cli.amount_paid','cli.status','sc.id as category_id')
            ->join('services as s','cli.support_item_number','=','s.support_item_number')
            ->join('service_categories as sc','s.support_category_name','=','sc.name')
            ->join('claims as c','cli.claim_id','=','c.id')
            ->whereIn('cli.status',[
                Claim::STATUS_RECONCILATION_DONE,
            ])
            ->where('cli.plan_id',null)
            ->where('cli.is_processed_by_script',0)
            ->orderBy('cli.id','desc')
            ->get();

        foreach ($claimItems as $claimItem)
        {
            $partPlan = Plan::where('participant_id',$claimItem->participant_id)
                            ->where('start_date','<=',$claimItem->start_date)
                            ->where('end_date','>=',$claimItem->end_date)
                            ->first();

            $itemData = ['is_processed_by_script' => 1];

            if($partPlan)
            {

                $totalCatBudget = 0;
                $catBudget = PlanBudget::where('plan_id',$partPlan->id)
                                        ->where('category_id',$claimItem->category_id)
                                        ->first();
                if($catBudget)
                {
                    $totalCatBudget = $catBudget->balance;

                    if($totalCatBudget == 0){
                        $itemData['script_status'] = 'plan found, but category budget exist';
                    }

                    if ($claimItem->amount_claimed > $totalCatBudget ){
                        $itemData['script_status'] = 'plan found & category budget is less than the claimed';
                    }
                    else
                    {
                        $catBudget->balance = $catBudget->balance - $claimItem->amount_paid;
                        $catBudget->spent = $catBudget->spent + $claimItem->amount_paid;
                        $catBudget->save();

                        $itemData['plan_id'] = $catBudget->plan_id;
                        $itemData['category_id'] = $catBudget->category_id;
                        $itemData['script_status'] = 'SUCCESS_DEDUCTED';
                    }
                }
           }
            else
            {
                $itemData['script_status'] = 'no plan found in date range';
            }

            DB::table('claim_line_items')
                ->where('id', $claimItem->id)
                ->update($itemData);
        }


        $claimItems = DB::table('claim_line_items  as cli')
                ->select('cli.id','cli.participant_id','c.start_date','c.end_date','cli.amount_claimed','cli.status','sc.id as category_id')
                ->join('services as s','cli.support_item_number','=','s.support_item_number')
                ->join('service_categories as sc','s.support_category_name','=','sc.name')
                ->join('claims as c','cli.claim_id','=','c.id')
                ->whereIn('cli.status',[
                    Claim::STATUS_APPROVED_BY_REPRESENTATIVE,
                    Claim::STATUS_APPROVED_BY_ADMIN,
                    Claim::STATUS_PROCESSED
                ])
                ->where('cli.is_processed_by_script',0)
                ->where('cli.plan_id',null)
                ->orderBy('cli.id','desc')
                ->get();

        foreach ($claimItems as $claimItem)
        {
            $partPlan = Plan::where('participant_id',$claimItem->participant_id)
                ->where('start_date','<=',$claimItem->start_date)
                ->where('end_date','>=',$claimItem->end_date)
                ->first();

            $itemData = ['is_processed_by_script' => 1];

            if($partPlan)
            {

                $totalCatBudget = 0;
                $catBudget = PlanBudget::where('plan_id',$partPlan->id)
                    ->where('category_id',$claimItem->category_id)
                    ->first();
                if($catBudget)
                {
                    $totalCatBudget = $catBudget->balance;

                    if($totalCatBudget == 0){
                        $itemData['script_status'] = 'plan found, but category budget exist';
                    }

                    if ($claimItem->amount_claimed > $totalCatBudget ){
                        $itemData['script_status'] = 'plan found & category budget is less than the claimed';
                    }
                    else
                    {
                        $catBudget->balance = $catBudget->balance - $claimItem->amount_claimed;
                        $catBudget->pending = $catBudget->pending + $claimItem->amount_claimed;
                        $catBudget->save();

                        $itemData['plan_id'] = $catBudget->plan_id;
                        $itemData['category_id'] = $catBudget->category_id;
                        $itemData['script_status'] = 'SUCCESS_PENDING';
                    }
                }
            }
            else
            {
                $itemData['script_status'] = 'no plan found in date range';
            }

            DB::table('claim_line_items')
                ->where('id', $claimItem->id)
                ->update($itemData);
        }

    }
}
