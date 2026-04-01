<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidContributorAndSeoFields extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'contributor_plan')) {
                $table->string('contributor_plan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'payment_status')) {
                $table->string('payment_status')->nullable()->after('contributor_plan');
            }
            if (!Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('users', 'activated_at')) {
                $table->timestamp('activated_at')->nullable()->after('stripe_customer_id');
            }
        });

        Schema::table('contributor_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('contributor_posts', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('featured_image');
            }
            if (!Schema::hasColumn('contributor_posts', 'feature_source_plan')) {
                $table->string('feature_source_plan')->nullable()->after('is_featured');
            }
            if (!Schema::hasColumn('contributor_posts', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('published_at');
            }
            if (!Schema::hasColumn('contributor_posts', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('contributor_posts', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('contributor_posts', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('contributor_posts', 'og_image')) {
                $table->string('og_image')->nullable()->after('canonical_url');
            }
            if (!Schema::hasColumn('contributor_posts', 'robots_index')) {
                $table->boolean('robots_index')->default(true)->after('og_image');
            }
            if (!Schema::hasColumn('contributor_posts', 'robots_follow')) {
                $table->boolean('robots_follow')->default(true)->after('robots_index');
            }
            if (!Schema::hasColumn('contributor_posts', 'schema_json_ld')) {
                $table->longText('schema_json_ld')->nullable()->after('robots_follow');
            }
        });

        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('content');
            }
            if (!Schema::hasColumn('blogs', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('blogs', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('blogs', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('blogs', 'og_image')) {
                $table->string('og_image')->nullable()->after('canonical_url');
            }
            if (!Schema::hasColumn('blogs', 'robots_index')) {
                $table->boolean('robots_index')->default(true)->after('og_image');
            }
            if (!Schema::hasColumn('blogs', 'robots_follow')) {
                $table->boolean('robots_follow')->default(true)->after('robots_index');
            }
            if (!Schema::hasColumn('blogs', 'schema_json_ld')) {
                $table->longText('schema_json_ld')->nullable()->after('robots_follow');
            }
        });

        Schema::table('home_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('home_pages', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('stat_label');
            }
            if (!Schema::hasColumn('home_pages', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('home_pages', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('home_pages', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('home_pages', 'og_image')) {
                $table->string('og_image')->nullable()->after('canonical_url');
            }
            if (!Schema::hasColumn('home_pages', 'robots_index')) {
                $table->boolean('robots_index')->default(true)->after('og_image');
            }
            if (!Schema::hasColumn('home_pages', 'robots_follow')) {
                $table->boolean('robots_follow')->default(true)->after('robots_index');
            }
            if (!Schema::hasColumn('home_pages', 'schema_json_ld')) {
                $table->longText('schema_json_ld')->nullable()->after('robots_follow');
            }
        });

        Schema::table('about_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('about_pages', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('image');
            }
            if (!Schema::hasColumn('about_pages', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('about_pages', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('about_pages', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('about_pages', 'og_image')) {
                $table->string('og_image')->nullable()->after('canonical_url');
            }
            if (!Schema::hasColumn('about_pages', 'robots_index')) {
                $table->boolean('robots_index')->default(true)->after('og_image');
            }
            if (!Schema::hasColumn('about_pages', 'robots_follow')) {
                $table->boolean('robots_follow')->default(true)->after('robots_index');
            }
            if (!Schema::hasColumn('about_pages', 'schema_json_ld')) {
                $table->longText('schema_json_ld')->nullable()->after('robots_follow');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'contributor_plan',
                'payment_status',
                'stripe_customer_id',
                'activated_at',
            ]);
        });

        Schema::table('contributor_posts', function (Blueprint $table) {
            $table->dropColumn([
                'is_featured',
                'feature_source_plan',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical_url',
                'og_image',
                'robots_index',
                'robots_follow',
                'schema_json_ld',
            ]);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical_url',
                'og_image',
                'robots_index',
                'robots_follow',
                'schema_json_ld',
            ]);
        });

        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical_url',
                'og_image',
                'robots_index',
                'robots_follow',
                'schema_json_ld',
            ]);
        });

        Schema::table('about_pages', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical_url',
                'og_image',
                'robots_index',
                'robots_follow',
                'schema_json_ld',
            ]);
        });
    }
}
