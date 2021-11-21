<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adss', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->enum('page',\Milano\Ads\Models\Ads::$pages);
            $table->string('ads');
            $table->string('image')->nullable();
            $table->string('link');
            $table->date('start_at');
            $table->date('expired_at');
            $table->enum('opening',\Milano\Ads\Models\Ads::$openings);
            $table->enum('confirmation_status',\Milano\Ads\Models\Ads::$confirmationStatuses)->default('pending');
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
        Schema::dropIfExists('adss');
    }
}
