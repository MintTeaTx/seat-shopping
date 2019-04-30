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
            $table->integer('volume');
            $table->text('reason');
            $table->integer('fuel_cost');
            $table->integer('fee');
            $table->integer('sub_total');
            $table->boolean('is_paid');
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
        Schema::dropIfExists('shopping_orders');
    }
}
