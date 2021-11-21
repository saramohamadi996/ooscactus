<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', \Milano\Order\Models\Order::$statuses)->default('registered');
//            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->bigInteger('total_price')->default(0);
            $table->string('name');
            $table->string('mobile', 14)->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('street')->nullable();
            $table->string('alley')->nullable();
            $table->string('no')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
    });}
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

