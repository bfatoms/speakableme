<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTeacherRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_teacher_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('rate', 10,4);
            $table->string('currency_code')->default("PHP");
            $table->unsignedInteger('class_type_id');
            $table->unsignedInteger('subject_id');
            $table->char('teacher_provider_id', 36);
            $table->char('student_provider_id', 36);            
            $table->unique(['subject_id','class_type_id','teacher_provider_id', 'student_provider_id', 'rate'],
                "subject_provider_class_type_teacher_rates");
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
        Schema::dropIfExists('base_teacher_rates');
    }
}
