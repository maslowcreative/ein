<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoApprovalColsInClaimLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim_line_items', function (Blueprint $table) {
            $table->unsignedInteger('auto_approval_process_counter')->default(0)->after('script_status');
            $table->string('auto_approval_status')->nullable()->after('auto_approval_process_counter');
            $table->dateTime('last_auto_approval_process_date')->nullable()->after('auto_approval_status');
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
            $table->dropColumn('auto_approval_process_counter');
            $table->dropColumn('auto_approval_status');
            $table->dropColumn('last_auto_approval_process_date');
        });
    }
}
