<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Services extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('services', function (Blueprint $table) {
            $table->string('support_item_number')->primary();
            $table->string('support_item_name');
            $table->string('reg_group_number');
            $table->string('reg_group_name');
            $table->string('support_category_number');
            $table->string('support_category_name');

            $table->float('ACT')->nullable();
            $table->float('NSW')->nullable();
            $table->float('NT')->nullable();
            $table->float('QLD')->nullable();
            $table->float('SA')->nullable();
            $table->float('TAS')->nullable();
            $table->float('VIC')->nullable();
            $table->float('remote')->nullable();
            $table->float('very_remote')->nullable();
            $table->string('unit')->nullable();
            $table->string('quote')->nullable();
            $table->string('non_face_to_face')->nullable();
            $table->string('provider_travel')->nullable();
            $table->string('short_notic_cancellations')->nullable();
            $table->string('ndia_requested_reports')->nullable();
            $table->string('irregular_sil_supports')->nullable();
            $table->string('type')->nullable();
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
        //
        Schema::dropIfExists('services');
    }
}
