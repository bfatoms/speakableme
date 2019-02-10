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
            $table->char('id', 36)->primary()->autoIncrement(false);
		    $table->char('role_id',36)->nullable();
		    $table->char('entity_id', 36)->nullable();
		    $table->string('first_name', 191)->nullable();
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

            // teacher fields
            $table->integer('peak1to15')->default(0);
		    $table->integer('peak16to31')->default(0);
		    $table->boolean('special_plotting_indefinite')->nullable();
		    $table->dateTime('special_plotting')->nullable();
		    $table->unsignedInteger('teacher_account_type_id')->default(1);
		    $table->string('bank_name', 191)->default('Bank of the Philippine Islands');
		    $table->string('bank_account_number', 191)->nullable();
            $table->string('bank_account_name', 191)->nullable();
            $table->decimal('base_rate', 10,4)->default(60.0000);

            // student fields
            $table->integer('immortal')->default(0);
		    $table->integer('student_account_type_id')->unsigned()->default(1);
		    $table->integer('trial_balance')->unsigned()->default(1);
		    $table->dateTime('trial_validity')->nullable();

		    $table->unique('email');
            $table->index('role_id');
            $table->index('nick');
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
