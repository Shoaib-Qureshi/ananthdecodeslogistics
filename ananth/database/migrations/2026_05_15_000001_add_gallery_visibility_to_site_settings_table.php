<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGalleryVisibilityToSiteSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('site_settings') || Schema::hasColumn('site_settings', 'gallery_page_visible')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('gallery_page_visible')->default(true)->after('footer_logo');
        });
    }

    public function down()
    {
        if (!Schema::hasTable('site_settings') || !Schema::hasColumn('site_settings', 'gallery_page_visible')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('gallery_page_visible');
        });
    }
}
