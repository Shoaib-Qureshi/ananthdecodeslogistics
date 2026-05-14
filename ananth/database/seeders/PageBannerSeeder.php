<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageBanner;

class PageBannerSeeder extends Seeder
{
    public function run()
    {
        $banners = [
            'blog' => [
                'eyebrow' => 'Editorial Insights',
                'heading' => 'Logistics Strategy, Decoded',
                'subheading' => 'Analysis, opinion, and practical deep-dives for logistics and supply chain leaders.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'expert_desk' => [
                'eyebrow' => 'The Expert Desk',
                'heading' => 'Expert Perspectives from the Field',
                'subheading' => 'Verified practitioners share real-world insights across logistics, supply chain, finance, technology, and beyond.',
                'cta_label' => 'Apply to The Expert Desk',
                'cta_link' => '/expert-desk/apply',
            ],
            'board_insights' => [
                'eyebrow' => 'Board Insights',
                'heading' => 'Strategic Intelligence for Logistics Leaders',
                'subheading' => 'Board-level thinking on governance, operational resilience, and the decisions shaping logistics businesses.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'book_reviews' => [
                'eyebrow' => 'Book Reviews',
                'heading' => 'Ideas Worth Carrying Forward',
                'subheading' => 'Thoughtful reviews and summaries for leaders who read to make better decisions.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'write_for_us' => [
                'eyebrow' => 'The Expert Desk',
                'heading' => 'Write for a logistics audience that reads with intent',
                'subheading' => 'Choose a contributor plan and build a real author presence with Ananth Decodes Logistics.',
                'cta_label' => 'View Plans',
                'cta_link' => '#pricing',
            ],
            'contributor_apply' => [
                'eyebrow' => 'The Expert Desk',
                'heading' => 'Apply to The Expert Desk',
                'subheading' => 'Choose your plan, tell us about your expertise, and start your contributor journey.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'free_signup' => [
                'eyebrow' => 'The Expert Desk',
                'heading' => 'Request a Free Account',
                'subheading' => 'Submit your contributor details for admin review before dashboard access is enabled.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'gallery' => [
                'eyebrow' => 'ADL Gallery',
                'heading' => 'A visual record of logistics thinking',
                'subheading' => 'Boardroom conversations, field perspectives, events, and the systems that keep ideas moving.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'contact' => [
                'eyebrow' => 'Contact',
                'heading' => 'Contact Us',
                'subheading' => 'Write to us or send your query through the contact form below.',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'privacy_policy' => [
                'eyebrow' => 'Policy',
                'heading' => 'Privacy Policy',
                'subheading' => 'Last Updated: 17 April, 2026',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'terms_conditions' => [
                'eyebrow' => 'Legal',
                'heading' => 'Terms & Conditions',
                'subheading' => 'Last Updated: 17 April, 2026',
                'cta_label' => null,
                'cta_link' => null,
            ],
            'disclaimer' => [
                'eyebrow' => 'Legal',
                'heading' => 'Disclaimer',
                'subheading' => 'Last Updated: 15 Jun, 2025',
                'cta_label' => null,
                'cta_link' => null,
            ],
        ];

        foreach ($banners as $key => $banner) {
            PageBanner::firstOrCreate(['key' => $key], $banner + ['is_active' => true]);
        }
    }
}
