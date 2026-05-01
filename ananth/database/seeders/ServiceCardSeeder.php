<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCard;

class ServiceCardSeeder extends Seeder
{
    public function run()
    {
        if (ServiceCard::count() > 0) {
            return;
        }

        $cards = [
            [
                'title'       => 'Logistics Advisory',
                'description' => 'Strategic advisory services for organisations navigating supply chain complexity — from network design to last-mile optimisation, delivered by practitioners with decades of real-world experience.',
                'status'      => 'active',
                'link_url'    => '/contact-us',
                'sort_order'  => 1,
                'visible'     => true,
            ],
            [
                'title'       => 'Research & Insights',
                'description' => 'In-depth research reports, white papers, and data-driven insights on India\'s logistics sector — designed for executives, investors, and policy professionals who need clarity, not noise.',
                'status'      => 'active',
                'link_url'    => '/blog',
                'sort_order'  => 2,
                'visible'     => true,
            ],
            [
                'title'       => 'The Expert Desk',
                'description' => 'A curated publishing platform for logistics practitioners to share original insights, commentary, and analysis with a targeted professional audience across India and South Asia.',
                'status'      => 'active',
                'link_url'    => '/expert-desk',
                'sort_order'  => 3,
                'visible'     => true,
            ],
            [
                'title'       => 'Training & Workshops',
                'description' => 'Practitioner-led training programmes, workshops, and masterclasses for logistics professionals at every career stage — from frontline operations to C-suite strategy.',
                'status'      => 'coming_soon',
                'link_url'    => null,
                'sort_order'  => 4,
                'visible'     => true,
            ],
        ];

        foreach ($cards as $data) {
            ServiceCard::create($data);
        }
    }
}
