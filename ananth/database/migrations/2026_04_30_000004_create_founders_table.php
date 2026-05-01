<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoundersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('founders')) {
            return;
        }

        Schema::create('founders', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow');
            $table->string('name');
            $table->string('title');
            $table->text('bio');
            $table->string('photo')->nullable();
            $table->string('signature_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('founders');
    }
}
