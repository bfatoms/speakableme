<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectTeacherRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_teacher_rates', function (Blueprint $table) {
            $table->increments('id');
            // rate is unique per entity, teacher, and subject
            $table->char('entity_id', 36);
            $table->unsignedInteger('subject_id');
            $table->char('teacher_id', 36);
            $table->unsignedInteger('class_type_id');
            $table->decimal('rate', 10,4);
            $table->string('currency_code')->default("PHP");
            $table->unique(['entity_id', 'teacher_id', 'subject_id', 'class_type_id'],
                'entity_teacher_subject_class_type_rate'
            );
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
        Schema::dropIfExists('subject_teacher_rates');
    }
}
