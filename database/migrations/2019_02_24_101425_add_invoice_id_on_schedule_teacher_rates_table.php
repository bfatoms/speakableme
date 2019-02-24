<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceIdOnScheduleTeacherRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_teacher_rates', function(Blueprint $table){
            $table->unsignedInteger('invoice_id')->nullable();
            $table->dropColumn('paid_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_teacher_rates', function(Blueprint $table){
            $table->dropColumn('invoice_id');
            $table->dateTime('paid_at')->nullable();
        });
    }
}
