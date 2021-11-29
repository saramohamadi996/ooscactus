<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageProductsTable extends Migration

{
    public function up()
    {
        Schema::create('image_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('src');
            $table->integer('main_image');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_products');
    }
}
