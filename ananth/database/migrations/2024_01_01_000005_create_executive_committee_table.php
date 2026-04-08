<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutiveCommitteeTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('executive_committee')) {
            return;
        }

        Schema::create('executive_committee', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('linkedin')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('executive_committee');
    }
}
