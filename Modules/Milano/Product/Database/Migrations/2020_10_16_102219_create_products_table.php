<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration

{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->unsigned();
            $table->unsignedBigInteger('category_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->string('title')->unique();
            $table->string('meta_description');
            $table->string('slug');
            $table->float('priority')->unique();
            $table->string('price',10);
            $table->string('seller_share', 5);
            $table->integer('stock');
            $table->string('code_product')->unique();
            $table->enum('status',\Milano\Product\Models\Product::$statuses);
            $table->enum('confirmation_status',\Milano\Product\Models\Product::$confirmationStatuses)->default('pending');
            $table->longText('body')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('CASCADE');
        });
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
        Schema::dropIfExists('products');
    }
}
