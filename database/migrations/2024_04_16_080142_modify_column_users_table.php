<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->addColumn('tinyInteger', 'user_gender')->default(0)->comment('0 = male, 1 = female, 2 = other');
            $table->addColumn('date', 'user_birthdate')->nullable();
            $table->string('user_address', 200)->nullable()->change();
            $table->string('user_phone_number', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_gender');
            $table->dropColumn('user_birthdate');
            $table->string('user_address', 50)->change();
            $table->string('user_phone_number', 50)->change();
        });
    }
}
