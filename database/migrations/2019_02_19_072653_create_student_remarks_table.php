<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->char('teacher_id', 36);
            $table->char('student_id', 36);
            $table->unsignedInteger('schedule_id');
            $table->text('grammar')->nullable();
            $table->text('pronunciation')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('tips_and_suggestion_for_student')->nullable();
            $table->text('remarks')->nullable();
            $table->text('screenshot')->nullable();
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
        Schema::dropIfExists('student_remarks');
    }
}
