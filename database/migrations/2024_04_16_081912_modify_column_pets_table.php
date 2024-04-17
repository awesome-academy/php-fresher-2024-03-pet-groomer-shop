<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnPetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->text('pet_description')->nullable()->change();
            $table->smallInteger('pet_gender')->default(0)->comment('0 = male, 1 = female')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('pet_description', 50)->nullable()->change();
            $table->smallInteger('pet_gender')->change();
        });
    }
}
