<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (!Schema::hasColumn('blogs', 'has_faqs')) {
                    $table->boolean('has_faqs')->default(false);
                }

                if (!Schema::hasColumn('blogs', 'faqs')) {
                    $table->json('faqs')->nullable();
                }
            });
        }

        if (Schema::hasTable('contributor_posts')) {
            Schema::table('contributor_posts', function (Blueprint $table) {
                if (!Schema::hasColumn('contributor_posts', 'has_faqs')) {
                    $table->boolean('has_faqs')->default(false);
                }

                if (!Schema::hasColumn('contributor_posts', 'faqs')) {
                    $table->json('faqs')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (Schema::hasColumn('blogs', 'faqs')) {
                    $table->dropColumn('faqs');
                }

                if (Schema::hasColumn('blogs', 'has_faqs')) {
                    $table->dropColumn('has_faqs');
                }
            });
        }

        if (Schema::hasTable('contributor_posts')) {
            Schema::table('contributor_posts', function (Blueprint $table) {
                if (Schema::hasColumn('contributor_posts', 'faqs')) {
                    $table->dropColumn('faqs');
                }

                if (Schema::hasColumn('contributor_posts', 'has_faqs')) {
                    $table->dropColumn('has_faqs');
                }
            });
        }
    }
};
