<?php

namespace App\Observers;

use App\Mail\ClaimDebug;
use App\Models\PlanBudget;
use Illuminate\Support\Facades\Mail;

class PlanBudgetObserver
{
    /**
     * Handle the PlanBudget "created" event.
     *
     * @param  \App\Models\PlanBudget  $planBudget
     * @return void
     */
    public function created(PlanBudget $planBudget)
    {
        //
        //dd('created observer');
    }


    /**
     * Handle the PlanBudget "updated" event.
     *
     * @param  \App\Models\PlanBudget  $planBudget
     * @return void
     */
    public function updated(PlanBudget $planBudget)
    {
       if( $planBudget->getOriginal('pending') >= 0 &&  $planBudget->pending < 0)
       {
           $request = request();
           $user = optional($request)->user();

           if($user)
           {
               $name = $user->other_name;
               $email = $user->email;
               $url = $request->url();
           }

           $data = [
               'name' => $name,
               'email' => $email,
               'plan_budget_id' =>  $planBudget->id,
               'amount' =>  $planBudget->amount,
               'balance' =>  $planBudget->balance,
               'pending' =>  $planBudget->pending,
               'spent' =>  $planBudget->spent,
               'amount_old' =>  $planBudget->getOriginal('amount'),
               'balance_old' =>  $planBudget->getOriginal('balance'),
               'pending_old' =>  $planBudget->getOriginal('pending'),
               'spent_old' =>  $planBudget->getOriginal('spent'),
               'url' => $url,
           ];

           Mail::to('ameerharram@gmail.com')
               ->send(new ClaimDebug($data));

       }
    }

    /**
     * Handle the PlanBudget "deleted" event.
     *
     * @param  \App\Models\PlanBudget  $planBudget
     * @return void
     */
    public function deleted(PlanBudget $planBudget)
    {
        //
        //dd('deleted observer');
    }

    /**
     * Handle the PlanBudget "restored" event.
     *
     * @param  \App\Models\PlanBudget  $planBudget
     * @return void
     */
    public function restored(PlanBudget $planBudget)
    {
        //
        //dd('restored observer');
    }

    /**
     * Handle the PlanBudget "force deleted" event.
     *
     * @param  \App\Models\PlanBudget  $planBudget
     * @return void
     */
    public function forceDeleted(PlanBudget $planBudget)
    {
        //
        //dd('forece delete observer');
    }
}
