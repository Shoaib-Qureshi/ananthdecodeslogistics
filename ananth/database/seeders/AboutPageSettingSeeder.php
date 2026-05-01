<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutPageSetting;

class AboutPageSettingSeeder extends Seeder
{
    public function run()
    {
        AboutPageSetting::firstOrCreate(['id' => 1], [
            'hero_eyebrow'                  => 'About Us',
            'hero_heading'                  => 'About Ananth Decodes Logistics',
            'hero_subheading'               => 'India\'s trusted thought-leadership platform for logistics and supply chain professionals.',
            'hero_image'                    => null,
            'intro_eyebrow'                 => 'Who We Are',
            'intro_heading'                 => 'Bridging the Knowledge Gap in Logistics',
            'intro_body'                    => "Ananth Decodes Logistics Private Limited is a thought-leadership platform founded to bridge the knowledge gap in India's logistics sector. We publish research, insights, and advisory content crafted by practitioners — for practitioners.\n\nOur mission is to make logistics strategy accessible, actionable, and grounded in real-world experience. From boardroom governance to last-mile innovation — we decode it all.\n\nFounded by Dr. Ananthakrishnan Janardhanan and Ms. Annapoorna Yadav TP, ADL brings over three decades of combined executive expertise to every piece of content we produce.",
            'vision_title'                  => 'Our Vision',
            'vision_body'                   => 'To be the leading thought-leadership platform shaping the future of logistics and supply chain across India and South Asia — where practitioners learn, connect, and grow.',
            'mission_title'                 => 'Our Mission',
            'mission_body'                  => 'To make logistics strategy accessible and actionable — publishing research, insights, and advisory content created by practitioners for practitioners, at every level of the supply chain.',
            'values_title'                  => 'Our Values',
            'values_body'                   => 'Integrity in every insight. Depth over noise. Practitioner-first perspectives. Sustainable thinking. Building a community that grows together — because the best ideas in logistics come from the people doing the work.',
            'services_eyebrow'              => 'What We Offer',
            'services_heading'              => 'Our Services',
            'services_intro'                => 'A suite of advisory, research, and publishing services for logistics professionals and organisations committed to staying ahead.',
            'transparency_note_title'       => 'A Note on Transparency',
            'transparency_note_body'        => 'Some services on The Expert Desk involve a monthly fee for featured placement. All editorial content published by ADL is independent, practitioner-led, and not influenced by commercial arrangements.',
            'transparency_note_disclaimer'  => 'ADL maintains strict editorial independence. Commercial relationships do not influence the editorial content we publish.',
            'cta_heading'                   => 'Ready to Get Started?',
            'cta_body'                      => 'Whether you want to read, contribute, or partner with ADL — we\'d love to hear from you.',
            'cta1_label'                    => 'Apply to The Expert Desk',
            'cta1_link'                     => '/expert-desk/apply',
            'cta2_label'                    => 'Contact Us',
            'cta2_link'                     => '/contact-us',
        ]);
    }
}
