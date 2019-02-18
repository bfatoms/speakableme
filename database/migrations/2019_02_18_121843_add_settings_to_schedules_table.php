<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsToSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedInteger('class_type_id');
            $table->unsignedInteger('min')->default(1);
            $table->unsignedInteger('max')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(local()){
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropColumn('class_type_id');
                $table->dropColumn('min');
                $table->dropColumn('max');
            });    
        }
    }
}
