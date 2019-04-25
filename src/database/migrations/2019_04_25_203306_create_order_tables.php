<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('shopping_orders');
        Schema::create('shopping_orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('user_id');
            $table->integer('total_cost');
            $table->json('details');
            $table->string('raw_details');
            $table->integer('status');
            $table->string('handler');
            $table->string('completed_date');
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
        //
        Schema::dropIfExists('seat_shopping_orders');
    }
}
