<?php

namespace App\Console\Commands;

use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Models\PlanBudget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BudgetBalancing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:balance-budget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will balance the budget.';

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
        $planBudgets = PlanBudget::join('plans as p','p.id','=','plan_budget.plan_id')
                             ->select('plan_budget.plan_id','p.participant_id','plan_budget.category_id' ,'plan_budget.amount', 'plan_budget.balance','plan_budget.pending','plan_budget.spent')
                             ->where('plan_budget.balance','<',0)
                             ->orWhere('plan_budget.pending','<',0)
                             ->orWhere('plan_budget.spent','<',0)
                             ->get()
                            ->toArray();
        foreach ($planBudgets as $budget)
        {
            $claimLineItem = ClaimLineItem::where('participant_id',$budget['participant_id'])
                                         ->where('plan_id',$budget['plan_id'])
                                         ->where('category_id',$budget['category_id'])
                                         ->whereNotIn('status',[Claim::STATUS_APPROVAL_PENDING,Claim::STATUS_DENIED_BY_REPRESENTATIVE,Claim::STATUS_CANCEL])
                                         ->groupBy('status')
                                         ->select('status',DB::raw('sum(amount_claimed) as amount_claimed,sum(amount_paid) as amount_paid'))
                                         ->get();

            $pendingData = $claimLineItem->where('status','<>',5)->sum('amount_claimed');
            $spentData = $claimLineItem->where('status',5)->sum('amount_paid');
            $totalSpentAndPendingData = $pendingData + $spentData;
            $balance = $budget['amount'] - $totalSpentAndPendingData;

            $statusScript = 'correct_balancing';

            if( $budget['amount'] < $totalSpentAndPendingData )
            {
                $statusScript = 'exceed_actual_amount';

                PlanBudget::where('plan_id',$budget['plan_id'])
                    ->where( 'category_id', $budget['category_id'])
                    ->update(['script_status' => $statusScript]);
            }
            else
            {
                PlanBudget::where('plan_id',$budget['plan_id'])
                    ->where( 'category_id', $budget['category_id'])
                    ->update(['balance' => $balance , 'pending' => $pendingData , 'spent' => $spentData, 'script_status' => $statusScript]);
            }

        }

        return 1;
    }
}
