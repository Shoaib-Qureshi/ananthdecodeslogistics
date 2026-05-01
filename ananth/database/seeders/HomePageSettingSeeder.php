<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomePageSetting;

class HomePageSettingSeeder extends Seeder
{
    public function run()
    {
        HomePageSetting::firstOrCreate(['id' => 1], [
            'hero_eyebrow'              => 'Ananth Decodes Logistics',
            'hero_heading'              => 'Your journey in logistics, made simpler.',
            'hero_subheading'           => 'Your daily route to supply chain intelligence — strategy, innovation, and sustainable growth decoded by Dr. Ananthakrishnan Janardhanan.',
            'hero_image'                => null,
            'hero_cta_primary_label'    => 'Explore Insights',
            'hero_cta_primary_link'     => '/blog',
            'hero_cta_secondary_label'  => 'About ADL',
            'hero_cta_secondary_link'   => '/about',
            'stat1_number'              => '25+',
            'stat1_label'               => 'Years Industry Experience',
            'stat2_number'              => '97%',
            'stat2_label'               => 'Customer Retention Rate',
            'stat3_number'              => '500+',
            'stat3_label'               => 'Articles & Insights Published',
            'stat4_number'              => '50+',
            'stat4_label'               => 'Companies Served Globally',
            'founder_eyebrow'           => 'Meet the Founder',
            'founder_heading'           => 'Dr. Ananthakrishnan Janardhanan',
            'founder_title_badge'       => 'Founder & Director, Ananth Decodes Logistics Private Limited',
            'founder_bio'               => 'A seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management. Dr. Ananth brings boardroom-level clarity to one of India\'s most complex sectors.',
            'founder_photo'             => null,
            'founder_cta_label'         => 'Read Full Profile',
            'founder_cta_link'          => '/about',
            'expertdesk_eyebrow'        => 'The Expert Desk',
            'expertdesk_heading'        => 'Share Your Expertise with a Logistics Audience',
            'expertdesk_body'           => 'The Expert Desk is ADL\'s platform for logistics practitioners to publish original insights, commentary, and research — reaching thousands of supply chain professionals every month.',
            'expertdesk_cta1_label'     => 'Apply to Write',
            'expertdesk_cta1_link'      => '/expert-desk/apply',
            'expertdesk_cta2_label'     => 'Read Expert Articles',
            'expertdesk_cta2_link'      => '/expert-desk',
            'boardinsights_eyebrow'     => 'Board Insights',
            'boardinsights_heading'     => 'Strategic Perspectives from India\'s Logistics Boardrooms',
            'boardinsights_body'        => 'Exclusive analysis, governance commentary, and strategic perspectives from the boardroom of India\'s logistics sector — curated for senior executives and decision-makers.',
            'boardinsights_cta_label'   => 'Explore Board Insights',
            'boardinsights_cta_link'    => '/board-insights',
            'services_eyebrow'          => 'What We Do',
            'services_heading'          => 'Our Services',
            'services_intro'            => 'End-to-end logistics advisory, research, and thought leadership tailored for modern supply chains.',
            'blog_eyebrow'              => 'Latest from ADL',
            'blog_heading'              => 'Latest Insights',
            'blog_subheading'           => 'Fresh perspectives on logistics, supply chain, and industry trends.',
            'blog_cta_label'            => 'View All Articles',
            'blog_cta_link'             => '/blog',
        ]);
    }
}
