<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_type_id');
            // entity id doesn't is now the entity creating the package
            $table->char('entity_id',36);
            $table->string('name');
            $table->decimal('unit_price',10,4);
            $table->unsignedInteger('number_of_classes');
            $table->decimal('base_price', 10,4);
            $table->unsignedInteger('duration_in_days');
            $table->decimal('additional', 10,4);
            $table->decimal('total',10,4);
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
        Schema::dropIfExists('entity_packages');
    }
}
