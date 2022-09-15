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
        //dd($partPlans->toArray());

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
            $totalCatBudget = $catBudget->balance;
        }

        if($totalCatBudget == 0){
            return [
                'status' => false,
                'message' => 'Participant does not have budget against category.'
            ];
        }

        if ($claimItem->amount_claimed > $totalCatBudget ){
            return [
                'status' => false,
                'message' => 'Participant does not have sufficient budget against category.'
            ];
        }

        return [
            'status' => true,
            'catBudget' => $catBudget,
        ];

    }

}
