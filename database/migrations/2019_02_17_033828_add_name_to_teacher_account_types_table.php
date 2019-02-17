<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToTeacherAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_account_types', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('rate');
            $table->dropColumn('minimum_student');
            $table->dropColumn('minimum_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(debug()){
            Schema::table('teacher_account_types', function (Blueprint $table) {
                $table->string('name');
            });    
        }
    }
}
