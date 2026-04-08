<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBookReviewsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('book_reviews')) {
            return;
        }

        Schema::table('book_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('book_reviews', 'status')) {
                $table->tinyInteger('status')->default(1)->after('buy_link');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('book_reviews')) {
            return;
        }

        Schema::table('book_reviews', function (Blueprint $table) {
            if (Schema::hasColumn('book_reviews', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
