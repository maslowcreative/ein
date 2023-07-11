<?php

namespace App\Console\Commands;

use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\ProviderBudget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProviderOldDataCapture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:provider-balance-budget';

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
        $plans = Plan::get()->toArray();
        config(['database.connections.mysql.strict' => false]);
        DB::reconnect();

        DB::beginTransaction();

        foreach ($plans as $plan){

            $lineItems = DB::table('claim_line_items')->where('plan_id',$plan['id'])->whereIn('status',[
                                Claim::STATUS_APPROVAL_PENDING,
                                Claim::STATUS_APPROVED_BY_REPRESENTATIVE,
                                Claim::STATUS_APPROVED_BY_ADMIN,
                                Claim::STATUS_PROCESSED,
                                Claim::STATUS_RECONCILATION_DONE
                            ])
                            ->select('plan_id','category_id','provider_id','participant_id',DB::raw("sum(IF(status = 5 , 0 , IFNULL(amount_claimed,0) ) ) as amount_claimed, sum(IF(status <> 5 , 0 , IFNULL(amount_paid,0) ) ) as amount_paid, status"))
                            ->groupBy('plan_id','provider_id','category_id','participant_id')
                            ->get();
            if($lineItems->count()> 0){

                foreach ($lineItems as $item)
                {

                    $planBudget = PlanBudget::where('plan_id',$item->plan_id)->where('category_id',$item->category_id)->first();
                    if($planBudget){

                        $amount = $item->amount_claimed + $item->amount_paid;
                        $pending = $item->amount_claimed;
                        $spent = $item->amount_paid;

                        $providerBudget = ProviderBudget::where('provider_id',$item->provider_id)
                                                          ->where('category_id',$item->category_id)
                                                          ->where('plan_budget_id',$planBudget->id)
                                                          ->where('plan_id',$item->plan_id)
                                                          ->first();

                        if(!$providerBudget){
                            $providerBudget = new ProviderBudget();
                            $providerBudget->amount = $amount;
                        }else
                        {
                            $providerBudget->amount = $providerBudget->amount;
                        }
                        $providerBudget->pending = $pending;
                        $providerBudget->spent = $spent;
                        $providerBudget->balance = 0;

                        $providerBudget->provider_id = $item->provider_id;
                        $providerBudget->plan_id = $item->plan_id;
                        $providerBudget->plan_budget_id = $planBudget->id;
                        $providerBudget->category_id = $item->category_id;
                        $providerBudget->save();
                    }
                }
            }

        }
        DB::commit();
        config(['database.connections.mysql.strict' => true]);
        DB::reconnect();
        return 0;
    }
}
