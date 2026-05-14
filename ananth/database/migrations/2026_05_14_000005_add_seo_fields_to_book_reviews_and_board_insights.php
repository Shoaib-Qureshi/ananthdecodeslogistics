<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoFieldsToBookReviewsAndBoardInsights extends Migration
{
    public function up()
    {
        foreach (['book_reviews', 'board_insights'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'meta_keywords')) {
                    $table->text('meta_keywords')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'og_image')) {
                    $table->string('og_image')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'robots_index')) {
                    $table->boolean('robots_index')->default(true);
                }
                if (!Schema::hasColumn($tableName, 'robots_follow')) {
                    $table->boolean('robots_follow')->default(true);
                }
                if (!Schema::hasColumn($tableName, 'schema_json_ld')) {
                    $table->longText('schema_json_ld')->nullable();
                }
            });
        }
    }

    public function down()
    {
        foreach (['book_reviews', 'board_insights'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columns = array_filter([
                    Schema::hasColumn($tableName, 'meta_title') ? 'meta_title' : null,
                    Schema::hasColumn($tableName, 'meta_description') ? 'meta_description' : null,
                    Schema::hasColumn($tableName, 'meta_keywords') ? 'meta_keywords' : null,
                    Schema::hasColumn($tableName, 'canonical_url') ? 'canonical_url' : null,
                    Schema::hasColumn($tableName, 'og_image') ? 'og_image' : null,
                    Schema::hasColumn($tableName, 'robots_index') ? 'robots_index' : null,
                    Schema::hasColumn($tableName, 'robots_follow') ? 'robots_follow' : null,
                    Schema::hasColumn($tableName, 'schema_json_ld') ? 'schema_json_ld' : null,
                ]);

                if ($columns) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
}
