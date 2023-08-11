<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInPlanBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_budget', function (Blueprint $table) {
            $table->float('balance')->default(0)->after('amount');
            $table->float('pending')->default(0)->after('balance');
            $table->float('spent')->default(0)->after('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_budget', function (Blueprint $table) {
            $table->dropColumn('balance');
            $table->dropColumn('pending');
            $table->dropColumn('spent');
        });
    }
}
