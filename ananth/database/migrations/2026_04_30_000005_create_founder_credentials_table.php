<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFounderCredentialsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('founder_credentials')) {
            return;
        }

        Schema::create('founder_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('credential');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('founder_credentials');
    }
}
