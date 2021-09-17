<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropServicesTable extends Migration
{

    public function up()
    {
        Schema::dropIfExists('services');
    }

    public function down()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('name')->unique();
            $table->string('key');
            $table->timestamps();
        });
    }

}
