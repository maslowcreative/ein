<?php


namespace App\Traits;

use App\Models\Claim;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\ProviderBudget;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Transaction;

trait ClaimsValidationTrait
{

    private function claimValidate($claimItem,$data = null)
    {
        $totalCatBudget = 0;
        if(!$data)
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
                //->where('status',1)
                ->orderBy('status', 'DESC')
                ->first();

            if (!$partPlans){
                return [
                    'status' => false,
                    'message' => 'Participant plan for specified date range does not exist.'
                ];
            }

            $catBudget = PlanBudget::where('plan_id',$partPlans->id)
                ->where('category_id',$category->id)
                ->first();

        }
        else
        {
            $catBudget = PlanBudget::where('plan_id',$data['plan_id'])
                ->where('category_id',$data['category_id'])
                ->first();
        }

        if($catBudget && !$data)
        {
            $totalCatBudget = $catBudget->balance;

        }elseif($catBudget && $data)
        {
            $totalCatBudget = $catBudget->balance + $claimItem->getOriginal('amount_claimed');
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

    private function claimValidateNew($claimItem,$data = null)
    {
        $totalCatBudget = 0;

        //Provider Submit Case
        if(!$data)
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
                                //->where('status',1)
                                ->orderBy('status', 'DESC')
                                ->first();

            if (!$partPlans){
                return [
                    'status' => false,
                    'message' => 'Participant plan for specified date range does not exist.'
                ];
            }

            $catBudget = PlanBudget::where('plan_id',$partPlans->id)
                ->where('category_id',$category->id)
                ->first();

        }
        //Admin or Representative submit case
        else
        {
            $catBudget = PlanBudget::where('plan_id',$data['plan_id'])
                ->where('category_id',$data['category_id'])
                ->first();
        }

        $providerCatBudget = null;
        if($catBudget){

            $providerCatBudget = ProviderBudget::where('category_id',$catBudget->category_id)
                ->where('plan_id',$catBudget->plan_id)
                ->where('plan_budget_id',$catBudget->id)
                ->where('provider_id',$claimItem->provider_id)
                ->first();
        }

        //Provider Submit Case
        if($providerCatBudget && $catBudget && !$data )
        {
            $totalCatBudget = $catBudget->balance;
            $totalProviderCatBudget = $providerCatBudget->balance;

        }elseif($catBudget && $data)
        {
            $totalCatBudget = $catBudget->balance + $claimItem->getOriginal('amount_claimed');
            $totalProviderCatBudget = $providerCatBudget->balance + $claimItem->getOriginal('amount_claimed');
        }


        if($totalCatBudget == 0 || $totalProviderCatBudget == 0){
            return [
                'status' => false,
                'message' => 'Insufficient funding allocated.'
            ];
        }

        if ($claimItem->amount_claimed > $totalCatBudget || $claimItem->amount_claimed > $totalProviderCatBudget ){
            return [
                'status' => false,
                'message' => 'Insufficient funding allocated.'
            ];
        }

        return [
            'status' => true,
            'catBudget' => $catBudget,
            'providerCatBudget' => $providerCatBudget
        ];

    }

    private function claimPreValidate($claimItem)
    {
        $totalCatBudget = 0;


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
                //->where('status',1)
                ->orderBy('status', 'DESC')
                ->first();

            if (!$partPlans){
                return [
                    'status' => false,
                    'message' => 'Participant plan for specified date range does not exist.'
                ];
            }

            $catBudget = PlanBudget::where('plan_id',$partPlans->id)
                ->where('category_id',$category->id)
                ->first();



        $providerCatBudget = null;
        if($catBudget){

            $providerCatBudget = ProviderBudget::where('category_id',$catBudget->category_id)
                ->where('plan_id',$catBudget->plan_id)
                ->where('plan_budget_id',$catBudget->id)
                ->where('provider_id',$claimItem->provider_id)
                ->first();
        }

        //Provider Submit Case
        if($providerCatBudget && $catBudget  )
        {
            $totalCatBudget = $catBudget->balance;
            $totalProviderCatBudget = $providerCatBudget->balance;

        }



        if($totalCatBudget == 0 || $totalProviderCatBudget == 0){
            return [
                'status' => false,
                'message' => 'Insufficient funding allocated.'
            ];
        }

        if ($claimItem->amount_claimed > $totalCatBudget || $claimItem->amount_claimed > $totalProviderCatBudget ){
            return [
                'status' => false,
                'message' => 'Insufficient funding allocated.'
            ];
        }

        return [
            'status' => true,
            'catBudget' => $catBudget,
            'providerCatBudget' => $providerCatBudget
        ];

    }



}
