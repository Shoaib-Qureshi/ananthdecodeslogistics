<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoFieldsToPageSettings extends Migration
{
    public function up()
    {
        foreach (['home_page_settings', 'about_page_settings'] as $tableName) {
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
                    $table->text('schema_json_ld')->nullable();
                }
            });
        }
    }

    public function down()
    {
        foreach (['home_page_settings', 'about_page_settings'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                foreach ([
                    'meta_title',
                    'meta_description',
                    'meta_keywords',
                    'canonical_url',
                    'og_image',
                    'robots_index',
                    'robots_follow',
                    'schema_json_ld',
                ] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}
