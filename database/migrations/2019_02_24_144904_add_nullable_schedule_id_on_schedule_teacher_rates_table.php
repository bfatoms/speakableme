<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableScheduleIdOnScheduleTeacherRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_teacher_rates', function(Blueprint $table){
            $table->unsignedInteger('schedule_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_teacher_rates', function(Blueprint $table){
            $table->unsignedInteger('schedule_id')->change();
        });
    }
}
