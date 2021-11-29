<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('image');
            $table->string('slug');
            $table->timestamps();
            $table->foreign( 'parent_id')->references('id')
                ->on('categories')->onDelete( 'SET NULL');
        });

    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
