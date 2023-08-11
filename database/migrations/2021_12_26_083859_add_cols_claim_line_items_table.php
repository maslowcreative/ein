<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsClaimLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim_line_items', function (Blueprint $table) {
            $table->dateTime('rec_date')->nullable()->after('status');
            $table->string('rec_capped_price')->nullable()->after('status');
            $table->string('rec_payment_request_number')->nullable()->after('status');
            $table->string('rec_payment_request_status')->nullable()->after('status');
            $table->boolean('rec_is_full_paid')->nullable()->after('status');
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
            $table->dropColumn('rec_is_full_paid');
            $table->dropColumn('rec_payment_request_status');
            $table->dropColumn('rec_payment_request_number');
            $table->dropColumn('rec_capped_price');
            $table->dropColumn('rec_date');
        });
    }
}
