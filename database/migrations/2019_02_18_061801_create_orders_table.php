<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_type_id');
            $table->char('user_id', 36);
            $table->string('name');
            $table->unsignedInteger('number_of_classes');
            $table->unsignedInteger('duration_in_days');
            $table->decimal('total_price', 10,4);
            $table->decimal('discount_price', 10,4);
            $table->decimal('price_paid', 10,4);
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
        Schema::dropIfExists('orders');
    }
}
