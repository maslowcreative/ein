<?php

namespace Database\Seeders;

use App\Models\PlanBudget;
use Illuminate\Database\Seeder;

class PlanBudgetBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budgets = PlanBudget::all();
        foreach ($budgets as $budget){
            //if($budget->balance == 0){
                $budget->balance = $budget->amount;
                $budget->pending = 0;
                $budget->spent = 0;
                $budget->save();
            //}
        }

    }
}
