<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorPostsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('contributor_posts')) {
            return;
        }

        Schema::create('contributor_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->string('featured_image')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contributor_posts');
    }
}
