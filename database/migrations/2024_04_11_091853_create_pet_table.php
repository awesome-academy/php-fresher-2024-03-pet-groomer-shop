<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('pet_id');
            $table->string('pet_name', 50);
            $table->tinyInteger('pet_type')->comment('1 = Cat, 2 = Dog');
            $table->tinyInteger('is_active')->comment('1 = active, 0 = inactive');
            $table->string('pet_description', 50)->nullable();
            $table->tinyInteger('pet_gender');
            $table->decimal('pet_weight', 6, 2);
            $table->dateTime('pet_birthdate')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('breed_id')->nullable();
            $table->foreign('breed_id')->references('breed_id')->on('breeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
