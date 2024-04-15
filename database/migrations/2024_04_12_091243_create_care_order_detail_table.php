<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_order_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('care_orders')->onDelete('cascade');
            $table->unsignedBigInteger('pet_service_id');
            $table->foreign('pet_service_id')->references('pet_service_id')->on('pet_services')->onDelete('cascade');
            $table->decimal('pet_service_price', 12, 2);
            $table->primary(['order_id', 'pet_service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_order_detail');
    }
}
