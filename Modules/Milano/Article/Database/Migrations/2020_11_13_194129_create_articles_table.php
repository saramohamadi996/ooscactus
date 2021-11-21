<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->longText('body');
            $table->string('image')->nullable();
            $table->enum('confirmation_status', ['pending'])->default('pending');

            $table->integer('viewCount')->default(0);
            $table->integer('commentCount')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('CASCADE');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');

            $table->primary(['article_id' , 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('articles');
    }
}
