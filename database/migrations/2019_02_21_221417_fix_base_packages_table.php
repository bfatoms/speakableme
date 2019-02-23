<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixBasePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_packages', function(Blueprint $table){
            $table->string('entity_id',36)->nullable()->change();
            $table->string('assigned_id',36)->nullable()->change();
            $table->string('student_provider_id', 36);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_packages', function(Blueprint $table){
            $table->dropColumn('entity_id');
            $table->dropColumn('assigned_id');
            $table->dropColumn('student_provider_id');
        });
    }
}
