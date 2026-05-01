<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run()
    {
        SiteSetting::firstOrCreate(['id' => 1], [
            'footer_tagline'      => 'Logistics leader sharing insights on strategy, innovation, and sustainable growth.',
            'footer_company_name' => 'Ananth Decodes Logistics Private Limited',
            'footer_copyright'    => '© ' . now()->year . ' Ananth Decodes Logistics Private Limited. All rights reserved.',
            'cin'                 => null,
            'social_linkedin'     => 'https://www.linkedin.com/in/ananthakrishnan-janardhanan/',
            'social_twitter'      => null,
            'social_instagram'    => null,
            'footer_logo'         => null,
        ]);
    }
}
