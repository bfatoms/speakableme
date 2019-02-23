<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('paid_at')->nullable();
            // an order being approved doesnt mean its been paid, the paid_at must not be empty
            // possible status are pending, approved
            // for payment use paid_at to determine payment status and date
            $table->string('status')->default('pending');
            $table->renameColumn('price_paid', 'price')->change();
            $table->decimal('discount_price', 10,4)->nullable();
            $table->string('currency_code')->default('USD');
            $table->unsignedInteger('voucher_id')->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('paid_at');
            // an order being approved doesnt mean its been paid, the paid_at must not be empty
            // possible status are pending, approved
            // for payment use paid_at to determine payment status and date
            $table->dropColumn('status');
            $table->renameColumn('price', 'price_paid')->change();
            $table->dropColumn('discount_price');
            $table->dropColumn('currency_code');
            $table->dropColumn('voucher_id');
            $table->dropColumn('deleted_at');
        });
    }
}
