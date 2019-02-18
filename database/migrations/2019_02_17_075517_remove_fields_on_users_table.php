<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('trial_balance');
            $table->dropColumn('trial_validity');
            $table->dropColumn('immortal');
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
            Schema::table('users', function(Blueprint $table){
                $table->unsignedInteger('trial_balance')->default(0);
                $table->dateTime('trial_validity')->nullable();
                $table->unsignedInteger('immortal')->default(0);
            });
        }
    }
}
