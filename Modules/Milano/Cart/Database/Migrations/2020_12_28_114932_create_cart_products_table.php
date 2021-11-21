<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('cart_id');
            $table->string('code_product')->unique();
            $table->integer('count')->default('0');
            $table->string('title');
            $table->integer('price');
            $table->integer('total_price');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_products');
    }
}
