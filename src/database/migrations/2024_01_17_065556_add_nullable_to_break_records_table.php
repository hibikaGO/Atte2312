<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToBreakRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('break_records', function (Blueprint $table) {
            $table->dateTime('break_end_time')->nullable()->change();
            $table->dateTime('break_start_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('break_records', function (Blueprint $table) {
            $table->dateTime('break_end_time')->change();
            $table->dateTime('break_start_time')->change();
        });
    }
}
