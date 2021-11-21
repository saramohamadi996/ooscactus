<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
//            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->string('status');
            $table->bigInteger('total_price')->default(0);
            $table->dateTime('expired_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users') ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
