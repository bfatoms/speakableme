<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('peak1to15')->default(0);
		    $table->integer('peak16to31')->default(0);
		    $table->boolean('special_plotting_indefinite')->nullable();
		    $table->dateTime('special_plotting')->nullable();
		    $table->unsignedInteger('teacher_account_type_id')->default(1);
		    $table->string('bank_name', 191)->default('Bank of the Philippine Islands');
		    $table->string('bank_account_number', 191)->nullable();
            $table->string('bank_account_name', 191)->nullable();
            $table->decimal('base_rate', 10,4)->default(60.0000);
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
        Schema::dropIfExists('teachers');
    }
}
