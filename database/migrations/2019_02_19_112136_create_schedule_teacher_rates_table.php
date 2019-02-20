<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTeacherRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_teacher_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->char('teacher_id', 36);
            $table->unsignedInteger('schedule_id');
            $table->decimal('fee', 10,4)->nullable();
            $table->decimal('penalty')->nullable();
            $table->decimal('incentive')->nullable();
            $table->string('currency_code')->default("PHP");
            $table->text('note')->nullable();
            $table->status('penalty_name')->nullable();
            $table->dateTimeTz('paid_at')->nullable();
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
        Schema::dropIfExists('schedule_teacher_rates');
    }
}
