<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTimeTz('starts_at');
            $table->dateTimeTz('ends_at');
            $table->char('user_id',36);
            $table->unsignedInteger('class_session_id');
            $table->string('status');
            $table->unsignedInteger('subject_id');
            $table->boolean('is_teacher_absent')->default(0);
            $table->text('absence_reason')->nullable();
            $table->char('actor_id', 36)->nullable();
            $table->text('actor_message')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('schedules');
    }
}
