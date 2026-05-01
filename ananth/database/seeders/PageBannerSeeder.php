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
        ];

        foreach ($banners as $key => $banner) {
            PageBanner::firstOrCreate(['key' => $key], $banner + ['is_active' => true]);
        }
    }
}
