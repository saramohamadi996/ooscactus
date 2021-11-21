<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->integer('percent');
            $table->bigInteger('limit')->nullable();
            $table->boolean('is_general')->default(0)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->enum('type'  , ['fixed' , 'percent'])->nullable();
            $table->enum('status'  , ['enable' , 'disable'])->default('disable');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('expired_at');
            $table->timestamps();
        });

        Schema::create('couponables', function (Blueprint $table) {
            $table->foreignId('coupon_id')->constrained('coupons')->cascadeOnDelete();
            $table->integer('couponable_id');
            $table->string('couponable_type');
        });

        Schema::create('coupon_used', function (Blueprint $table) {
            $table->foreignId('coupon_id')->constrained('coupons')->cascadeOnDelete();
//            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_used');
        Schema::dropIfExists('couponables');
        Schema::dropIfExists('coupons');
    }
}


