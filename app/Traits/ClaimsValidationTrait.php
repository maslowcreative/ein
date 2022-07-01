<?php


namespace App\Traits;

use App\Models\Claim;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Transaction;

trait ClaimsValidationTrait
{

    private function claimValidate($claimItem)
    {
        $claim = Claim::where('id',$claimItem->claim_id)->firstOrFail();

        if (!$claim){
            return [
                'status' => false,
                'message' => 'Claim does not exist.'
            ];
        }

        $service = Service::where('support_item_number',$claimItem->support_item_number)->firstOrFail();

        $category = ServiceCategory::where('name',$service->support_category_name)->firstOrFail();

        if (!$category){
            return [
                'status' => false,
                'message' => 'Category does not exist.'
            ];
        }

        $partPlans = Plan::where('participant_id',$claimItem->participant_id)
                         ->where('start_date','<=',$claim->start_date)
                         ->where('end_date','>=',$claim->end_date)
                         ->first();

        if (!$partPlans){
            return [
                'status' => false,
                'message' => 'Participant plan for specified date range does not exist.'
            ];
        }
        $totalCatBudget = 0;
        $catBudget = PlanBudget::where('plan_id',$partPlans->id)
                              ->where('category_id',$category->id)
                              ->first();
        if($catBudget)
        {
            $totalCatBudget = $catBudget->amount;
        }

        if($totalCatBudget == 0){
            return [
                'status' => false,
                'message' => 'Participant does not have budget against category.'
            ];
        }

        $transactions = Transaction::where('plan_category_id',$category->id)
                                    ->where('plan_id',$partPlans->id)
                                    ->where('claim_item_id', '<>',$claimItem->id)
                                    ->active()
                                    ->get();

        if($transactions->isEmpty() &&  $claimItem->amount_claimed > $totalCatBudget ){
            return [
                'status' => false,
                'message' => 'Participant does not have sufficient budget against category.'
            ];
        }

        if( !$transactions->isEmpty() )
        {
            $totalCatConsumedAmount = $transactions->sum('amount_paid');
            $totalCatBudget = $totalCatBudget - $totalCatConsumedAmount;
        }

        if(!$transactions->isEmpty() && $claimItem->amount_claimed > $totalCatBudget ){
            return [
                'status' => false,
                'message' => 'Participant does not have sufficient budget against category.'
            ];
        }


        Transaction::where('plan_category_id',$category->id)
            ->where('plan_id',$partPlans->id)
            ->where('claim_item_id',$claimItem->id)
            ->active()
            ->get();

        /*
            $table->unsignedInteger('claim_id');
            $table->unsignedInteger('claim_item_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_category_id');
            $table->unsignedInteger('participant_id');
            $table->unsignedInteger('provider_id');
            $table->smallInteger('status');
            $table->float('claimed_amount');
            $table->float('paid_amount');
        */
        //Transaction::
        //dd($claim->start_date,$claim->end_date,$partPlans->toArray(),$category->name);
    }

}
