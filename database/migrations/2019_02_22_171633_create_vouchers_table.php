<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->char('student_provider_id', 36);
            $table->string('code', 20);
            $table->boolean('is_fixed')->default(true);
            $table->decimal('value', 10,4);
            $table->string('currency_code')->default('USD');
            $table->string('status')->default('inactive');
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->unsignedInteger('remaining')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->unique(['student_provider_id','code']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
