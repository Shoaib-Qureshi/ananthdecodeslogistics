<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePageSettingsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('home_page_settings')) {
            return;
        }

        Schema::create('home_page_settings', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_heading')->nullable();
            $table->string('hero_subheading')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_cta_primary_label')->nullable();
            $table->string('hero_cta_primary_link')->nullable();
            $table->string('hero_cta_secondary_label')->nullable();
            $table->string('hero_cta_secondary_link')->nullable();
            // Stats strip
            $table->string('stat1_number')->default('25+');
            $table->string('stat1_label')->default('Years Industry Experience');
            $table->string('stat2_number')->default('97%');
            $table->string('stat2_label')->default('Customer Retention Rate');
            $table->string('stat3_number')->default('500+');
            $table->string('stat3_label')->default('Articles & Insights Published');
            $table->string('stat4_number')->default('50+');
            $table->string('stat4_label')->default('Companies Served Globally');
            // Founder preview
            $table->string('founder_eyebrow')->nullable();
            $table->string('founder_heading')->nullable();
            $table->string('founder_title_badge')->nullable();
            $table->text('founder_bio')->nullable();
            $table->string('founder_photo')->nullable();
            $table->string('founder_cta_label')->nullable();
            $table->string('founder_cta_link')->nullable();
            // Expert Desk section
            $table->string('expertdesk_eyebrow')->nullable();
            $table->string('expertdesk_heading')->nullable();
            $table->text('expertdesk_body')->nullable();
            $table->string('expertdesk_cta1_label')->nullable();
            $table->string('expertdesk_cta1_link')->nullable();
            $table->string('expertdesk_cta2_label')->nullable();
            $table->string('expertdesk_cta2_link')->nullable();
            // Board Insights teaser
            $table->string('boardinsights_eyebrow')->nullable();
            $table->string('boardinsights_heading')->nullable();
            $table->text('boardinsights_body')->nullable();
            $table->string('boardinsights_cta_label')->nullable();
            $table->string('boardinsights_cta_link')->nullable();
            // Services section header
            $table->string('services_eyebrow')->nullable();
            $table->string('services_heading')->nullable();
            $table->text('services_intro')->nullable();
            // Blog section header
            $table->string('blog_eyebrow')->nullable();
            $table->string('blog_heading')->nullable();
            $table->string('blog_subheading')->nullable();
            $table->string('blog_cta_label')->nullable();
            $table->string('blog_cta_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_page_settings');
    }
}
