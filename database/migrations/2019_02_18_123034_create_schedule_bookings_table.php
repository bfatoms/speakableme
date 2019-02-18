<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->char('user_id', 36);
            $table->unsignedInteger('balance_id');
            $table->text('message')->nullable();
            $table->boolean('is_student_absent')->default(0);
            $table->text('absence_reason')->nullable();
            $table->char('actor_id',36)->nullable();
            $table->text('actor_message')->nullable();
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
        Schema::dropIfExists('schedule_bookings');
    }
}
