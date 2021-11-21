<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanersTable extends Migration
{
    public function up()
    {
        Schema::create('baners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('link');
            $table->enum('confirmation_status',
                \Milano\Baner\Models\Baner::$confirmationStatuses)->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('baners');
    }
}
