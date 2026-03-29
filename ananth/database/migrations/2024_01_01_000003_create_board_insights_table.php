<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardInsightsTable extends Migration
{
    public function up()
    {
        Schema::create('board_insights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->tinyInteger('status')->default(0); // 0=draft, 1=published
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('board_insights');
    }
}
