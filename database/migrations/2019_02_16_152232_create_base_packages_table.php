<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_type_id');
            $table->unsignedInteger('entity_type_id');
            $table->string('name');
            $table->decimal('unit_price',10,4);
            $table->unsignedInteger('number_of_classes');
            $table->decimal('base_price', 10,4);
            $table->unsignedInteger('duration_in_days');
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
        Schema::dropIfExists('base_packages');
    }
}
