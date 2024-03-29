<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColInRepresetnativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('representatives', function (Blueprint $table) {
            $table->unsignedSmallInteger('auto_approval_days')->default(4)->after('flag_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('representatives', function (Blueprint $table) {
            $table->dropColumn('auto_approval_days');
        });
    }
}
