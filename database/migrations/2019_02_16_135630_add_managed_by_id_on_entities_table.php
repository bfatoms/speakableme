<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagedByIdOnEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function(Blueprint $table){
            $table->char('managed_by_id', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(config('app.debug') === true){
            Schema::table('entities', function(Blueprint $table){
                $table->dropColumn('managed_by_id');
            });
        }
    }
}
