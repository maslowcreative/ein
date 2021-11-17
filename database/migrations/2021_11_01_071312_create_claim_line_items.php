<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimLineItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_line_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('claim_id');
            $table->string('support_item_number');
            $table->time('hours');
            $table->float('unit_price');
            $table->enum('gst_code',collect(\App\Models\Claim::TAX_TYPES)->keys()->toArray());

            $table->enum('claim_type', collect(\App\Models\Claim::CLAIM_TYPES)->keys()->toArray())->nullable();
            $table->enum('cancellation_reason', collect(\App\Models\Claim::CANCELLATION_REASONS)->keys()->toArray())->nullable();



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
        Schema::dropIfExists('claim_line_items');
    }
}
