<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNameFromOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('transaction_id')->nullable();
            $table->char('student_provider_id', 36);
            $table->dateTime('approved_at')->nullable();
            $table->unique(['student_provider_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->dropColumn('transaction_id');
            $table->dropColumn('student_provider_id');
            $table->dropColumn('approved_at');
        });
    }
}
