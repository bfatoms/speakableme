<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
		    $table->unsignedInteger('role_id')->unsigned()->nullable();
		    $table->unsignedInteger('school_id')->nullable();
		    $table->unsignedInteger('city_id')->nullable();
		    $table->unsignedInteger('country_id')->nullable();
		    $table->string('first_name', 191);
		    $table->string('last_name', 191)->nullable();
		    $table->string('middle_name', 191)->nullable();
		    $table->string('nick', 100)->nullable();
		    $table->string('email', 191);
		    $table->string('avatar', 191)->default('users/default.png');
		    $table->string('password', 191);
		    $table->string('remember_token', 100)->nullable();
		    $table->string('gender', 10)->nullable();
		    $table->string('qq', 50)->nullable();
		    $table->string('mobile', 30)->nullable();
		    $table->string('wechat', 50)->nullable();
		    $table->string('address')->nullable();
		    $table->string('timezone', 30)->default('Asia/Shanghai');
		    $table->string('lang', 20)->default('en');		
		    $table->dateTime('birth_date')->nullable();
		    $table->boolean('disabled')->default(0);
		    $table->boolean('password_changed')->nullable();
		    $table->unique('email','users_email_unique');
            $table->index('role_id','users_role_id_foreign');
            $table->index('nick','users_nick_index');
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
        Schema::dropIfExists('users');
    }
}
