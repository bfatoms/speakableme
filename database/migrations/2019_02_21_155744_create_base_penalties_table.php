<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasePenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_penalties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('class_type_id');
            $table->char('teacher_provider_id', 36);
            $table->decimal('rate', 10,4);
            $table->string('currency_code')->default("PHP");
            $table->unsignedInteger('incur_at')->default(2);
            $table->unique(['subject_id','class_type_id','teacher_provider_id', 'rate'],
                "subject_provider_class_type_penalties");
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
        Schema::dropIfExists('base_penalties');
    }
}
