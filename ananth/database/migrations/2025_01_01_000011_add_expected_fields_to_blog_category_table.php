<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddExpectedFieldsToBlogCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_category', 'category_name')) {
                $table->string('category_name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('blog_category', 'category_slug')) {
                $table->string('category_slug')->nullable()->after('category_name');
            }
        });

        // Backfill from legacy columns if present
        if (Schema::hasColumn('blog_category', 'name')) {
            DB::table('blog_category')
                ->whereNull('category_name')
                ->update(['category_name' => DB::raw('name')]);
        }
        if (Schema::hasColumn('blog_category', 'slug')) {
            DB::table('blog_category')
                ->whereNull('category_slug')
                ->update(['category_slug' => DB::raw('slug')]);
        }
    }

    public function down()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            if (Schema::hasColumn('blog_category', 'category_name')) {
                $table->dropColumn('category_name');
            }
            if (Schema::hasColumn('blog_category', 'category_slug')) {
                $table->dropColumn('category_slug');
            }
        });
    }
}
