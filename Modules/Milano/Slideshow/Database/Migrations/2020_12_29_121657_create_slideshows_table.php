<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideshowsTable extends Migration
{
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('link');
            $table->enum('confirmation_status',\Milano\Slideshow\Models\Slideshow::$confirmationStatuses)->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slideshows');
    }
}
