<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->decimal('order_total_price', 12, 2);
            $table->tinyInteger('order_status')->default(0);
            $table->string('order_note', 100)->nullable();
            $table->dateTime('order_received_date');
            $table->dateTime('returned_date')->nullable();
            $table->decimal('order_coupon_price', 12, 2)->nullable();
            $table->decimal('order_hotel_price', 12, 2)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('coupon_id')->on('coupons');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->foreign('pet_id')->references('pet_id')->on('pets')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_orders');
    }
}
