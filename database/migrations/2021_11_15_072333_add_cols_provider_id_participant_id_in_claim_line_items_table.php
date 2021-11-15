<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsProviderIdParticipantIdInClaimLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim_line_items', function (Blueprint $table) {
            //$table->unsignedInteger('provider_id')->after('claim_id');
            //$table->unsignedInteger('participant_id')->after('provider_id');
            $table->float('amount_claimed')->after('unit_price');
            $table->float('amount_paid')->nullable()->after('amount_claimed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claim_line_items', function (Blueprint $table) {
            $table->dropColumn('provider_id');
            $table->dropColumn('participant_id');
            $table->dropColumn('amount_claimed');
            $table->dropColumn('amount_paid');
        });
    }
}
