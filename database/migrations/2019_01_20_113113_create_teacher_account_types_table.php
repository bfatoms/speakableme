<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('rate',10,4)->nullable();
            $table->unsignedInteger('minimum_student')->nullable();
            $table->unsignedInteger('minimum_class')->nullable();          
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
        Schema::dropIfExists('teacher_account_types');
    }
}
