<?php

use App\Models\PageBanner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('page_banners')) {
            return;
        }

        $banners = [
            'write_for_us' => ['eyebrow' => 'The Expert Desk', 'heading' => 'Write for a logistics audience that reads with intent', 'subheading' => 'Choose a contributor plan and build a real author presence with Ananth Decodes Logistics.', 'cta_label' => 'View Plans', 'cta_link' => '#pricing'],
            'contributor_apply' => ['eyebrow' => 'The Expert Desk', 'heading' => 'Apply to The Expert Desk', 'subheading' => 'Choose your plan, tell us about your expertise, and start your contributor journey.', 'cta_label' => null, 'cta_link' => null],
            'free_signup' => ['eyebrow' => 'The Expert Desk', 'heading' => 'Request a Free Account', 'subheading' => 'Submit your contributor details for admin review before dashboard access is enabled.', 'cta_label' => null, 'cta_link' => null],
            'gallery' => ['eyebrow' => 'ADL Gallery', 'heading' => 'A visual record of logistics thinking', 'subheading' => 'Boardroom conversations, field perspectives, events, and the systems that keep ideas moving.', 'cta_label' => null, 'cta_link' => null],
            'contact' => ['eyebrow' => 'Contact', 'heading' => 'Contact Us', 'subheading' => 'Write to us or send your query through the contact form below.', 'cta_label' => null, 'cta_link' => null],
            'privacy_policy' => ['eyebrow' => 'Policy', 'heading' => 'Privacy Policy', 'subheading' => 'Last Updated: 17 April, 2026', 'cta_label' => null, 'cta_link' => null],
            'terms_conditions' => ['eyebrow' => 'Legal', 'heading' => 'Terms & Conditions', 'subheading' => 'Last Updated: 17 April, 2026', 'cta_label' => null, 'cta_link' => null],
            'disclaimer' => ['eyebrow' => 'Legal', 'heading' => 'Disclaimer', 'subheading' => 'Last Updated: 15 Jun, 2025', 'cta_label' => null, 'cta_link' => null],
        ];

        foreach ($banners as $key => $banner) {
            PageBanner::firstOrCreate(['key' => $key], $banner + ['is_active' => true]);
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('page_banners')) {
            return;
        }

        PageBanner::whereIn('key', [
            'write_for_us',
            'contributor_apply',
            'free_signup',
            'gallery',
            'contact',
            'privacy_policy',
            'terms_conditions',
            'disclaimer',
        ])->delete();
    }
};
