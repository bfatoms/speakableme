<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->char('user_id', 36);
            $table->unsignedInteger('balance_type_id')->default(1);
            $table->unsignedInteger('remaining')->default(0);
            $table->unsignedInteger('total');
            $table->unsignedInteger('order_id')->nullable();
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
        if(debug()){
            Schema::dropIfExists('balances');
        }
    }
}
