<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('orderId');
            $table->unsignedBigInteger('productId');
            $table->integer('quantity');
            $table->string('unitPrice');
            $table->string('totalPrice');
            $table->timestamps();

            $table->foreign('orderId')
                ->references('id')
                ->on('orders')
                ->onDelete('CASCADE');

            $table->foreign('productId')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
