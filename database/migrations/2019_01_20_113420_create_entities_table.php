<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->char('id', 36)->primary()->autoIncrement(false);
            $table->char('entity_type_id', 36);
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('prefix', 10)->nullable();
            $table->boolean('manage_students')->default(0);
            $table->boolean('manage_teachers')->default(0);
            $table->boolean('manage_clients')->default(0);
            $table->string('default_email');
            $table->string('default_lang')->default('en');
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
        Schema::dropIfExists('entities');
    }
}
