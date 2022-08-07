<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('old_claim_id')->nullable();
            $table->string('old_claim_sr_no')->nullable();
            $table->string('claim_ref')->nullable();
            $table->string('provider_master_id')->nullable();
            $table->unsignedInteger('provider_system_id')->nullable();
            $table->string('participant_master_id')->nullable();
            $table->unsignedInteger('participant_system_id')->nullable();
            $table->string('item_master_id')->nullable();
            $table->string('service_start_date')->nullable();
            $table->string('service_end_date')->nullable();
            $table->string('unit_number')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('gst')->nullable();
            $table->string('claim_amount')->nullable();
            $table->string('received_amount')->nullable();
            $table->string('paid_date')->nullable();
            $table->string('claim_type')->nullable();
            $table->string('claim_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('temp_claims');
    }
}
