<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->char('teacher_provider_id', 36);
            $table->char('student_provider_id', 36);
            $table->unique(['teacher_provider_id','student_provider_id'],
                'teacher_student_provider');
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
        Schema::dropIfExists('entity_assignments');
    }
}
