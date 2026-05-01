<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCardsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('service_cards')) {
            return;
        }

        Schema::create('service_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->enum('status', ['active', 'coming_soon'])->default('active');
            $table->string('link_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_cards');
    }
}
