<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertDeskPillarsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('expert_desk_pillars')) {
            return;
        }

        Schema::create('expert_desk_pillars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expert_desk_pillars');
    }
}
