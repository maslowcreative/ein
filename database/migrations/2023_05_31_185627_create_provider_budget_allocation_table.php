<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderBudgetAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_budget_allocation', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_budget_id');
            $table->unsignedInteger('category_id');

            $table->float('amount');
            $table->float('balance');
            $table->float('pending');
            $table->float('spent');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_budget_allocation');
    }
}
