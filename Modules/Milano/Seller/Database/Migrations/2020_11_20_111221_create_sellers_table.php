<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sellers', function (Blueprint $table) {
            $table->id();
            $table->text('titre');
            $table->string('title1');
            $table->string('title2');
            $table->string('title3');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->string('percent');
            $table->string('price');
            $table->string('payment');
            $table->string('telegram');
            $table->string('title');
            $table->string('head');
            $table->longText('rules');
            $table->enum('confirmation_status',\Milano\Seller\Models\Seller::$confirmationStatuses)->default('pending');
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
        Schema::dropIfExists('Sellers');
    }
}
