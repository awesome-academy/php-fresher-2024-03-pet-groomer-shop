<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('user_id');
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('username')->unique();
            $table->string('user_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_password');
            $table->string('user_address', 50);
            $table->string('user_phone_number', 50);
            $table->unsignedTinyInteger('fails_attempted')->default(0);
            $table->dateTime('last_attempted')->nullable();
            $table->integer('lock_until')->default(0);
            $table->tinyInteger('is_admin')->default(0)->comment('0 = user, 1 = admin');
            $table->tinyInteger('is_active')->default(0)->comment('0 = inactive, 1 = active');
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
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
