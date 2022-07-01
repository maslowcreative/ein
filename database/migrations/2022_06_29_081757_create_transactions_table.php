<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('claim_id');
            $table->unsignedInteger('claim_item_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_category_id');
            $table->unsignedInteger('participant_id');
            $table->unsignedInteger('provider_id');
            $table->smallInteger('status');
            $table->float('claimed_amount');
            $table->float('paid_amount');
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
        Schema::dropIfExists('transactions');
    }
}
