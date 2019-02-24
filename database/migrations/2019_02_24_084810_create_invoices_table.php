<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->dateTime('paid_at')->nullable();
            $table->string('status')->default('pending');
            $table->char('teacher_id', 36);
            $table->char('teacher_provider_id', 36);
            $table->string('bank_name')->default('Bank of The Philippine Islands')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->char('entity_id', 36);
            $table->char('actor_id', 36)->nullable();
            $table->string('actor')->default('system');
            $table->decimal('penalty', 10,4)->nullable();
            $table->decimal('fee', 10,4)->nullable();
            $table->decimal('incentive', 10,4)->nullable();
            $table->decimal('total', 10,4)->nullable();
            $table->dateTime('cut_off_starts_at');
            $table->dateTime('cut_off_ends_at');
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
        Schema::dropIfExists('invoices');
    }
}
