<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddionalColsToClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dateTime('representative_approved')->nullable()->after('participant_approved');
            $table->dateTime('admin_approved')->nullable()->after('representative_approved');
            $table->string('invoice_path')->after('claim_reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn(['representative_approved','admin_approved','invoice_path']);
        });
    }
}
