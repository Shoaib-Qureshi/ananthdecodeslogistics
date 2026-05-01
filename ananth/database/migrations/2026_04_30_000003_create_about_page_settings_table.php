<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutPageSettingsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('about_page_settings')) {
            return;
        }

        Schema::create('about_page_settings', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_heading')->nullable();
            $table->string('hero_subheading')->nullable();
            $table->string('hero_image')->nullable();
            // Company intro
            $table->string('intro_eyebrow')->nullable();
            $table->string('intro_heading')->nullable();
            $table->text('intro_body')->nullable();
            // Vision / Mission / Values
            $table->string('vision_title')->default('Our Vision');
            $table->text('vision_body')->nullable();
            $table->string('mission_title')->default('Our Mission');
            $table->text('mission_body')->nullable();
            $table->string('values_title')->default('Our Values');
            $table->text('values_body')->nullable();
            // Services section header
            $table->string('services_eyebrow')->nullable();
            $table->string('services_heading')->nullable();
            $table->text('services_intro')->nullable();
            // Transparency note
            $table->text('transparency_note_title')->nullable();
            $table->text('transparency_note_body')->nullable();
            $table->text('transparency_note_disclaimer')->nullable();
            // CTA strip
            $table->string('cta_heading')->nullable();
            $table->text('cta_body')->nullable();
            $table->string('cta1_label')->nullable();
            $table->string('cta1_link')->nullable();
            $table->string('cta2_label')->nullable();
            $table->string('cta2_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_page_settings');
    }
}
