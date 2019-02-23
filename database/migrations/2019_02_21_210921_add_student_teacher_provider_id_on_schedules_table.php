<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentTeacherProviderIdOnSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // LOGIC if this 
            $table->char('student_provider_id', 36)->nullable();
            $table->char('teacher_provider_id', 36);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // LOGIC if this 
            $table->dropColumn('student_provider_id');
            $table->dropColumn('teacher_provider_id');
        });
    }
}
