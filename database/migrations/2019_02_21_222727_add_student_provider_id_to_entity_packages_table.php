<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentProviderIdToEntityPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_packages', function (Blueprint $table) {
            $table->string('student_provider_id', 36);
            $table->string('entity_id', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_packages', function (Blueprint $table) {
            $table->dropColumn('student_provider_id');
            $table->dropColumn('entity_id');
        });
    }
}
