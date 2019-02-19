<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderNumberToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // format is ENTITY-PREFIX-sequential-[0-9]{5}-random_string
            // KS-160732-K243
            $table->string('code');
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
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('code');
            });    
        }
    }
}
