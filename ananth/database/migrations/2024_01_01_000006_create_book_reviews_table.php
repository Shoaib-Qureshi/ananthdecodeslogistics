<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReviewsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('book_reviews')) {
            return;
        }

        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->string('published')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('detail_review')->nullable();
            $table->string('cover')->nullable();
            $table->string('buy_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_reviews');
    }
}
