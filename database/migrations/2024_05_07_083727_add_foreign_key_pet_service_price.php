<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyPetServicePrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_service_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_service_id')->nullable();
            $table->foreign('pet_service_id')->references('pet_service_id')->on('pet_services')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_service_prices', function (Blueprint $table) {
            $table->dropForeign(['pet_service_id']);
            $table->dropColumn('pet_service_id');
        });
    }
}
