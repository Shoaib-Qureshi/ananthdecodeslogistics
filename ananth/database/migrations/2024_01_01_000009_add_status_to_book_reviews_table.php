<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBookReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('buy_link');
        });
    }

    public function down()
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
