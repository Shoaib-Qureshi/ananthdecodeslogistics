<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpertDeskPillar;

class ExpertDeskPillarSeeder extends Seeder
{
    public function run()
    {
        if (ExpertDeskPillar::count() > 0) {
            return;
        }

        $pillars = [
            [
                'title'      => 'Publish Original Insights',
                'body'       => 'Share your expertise through articles, commentary, and analysis — reviewed and published on ADL\'s platform.',
                'sort_order' => 1,
            ],
            [
                'title'      => 'Build Your Professional Brand',
                'body'       => 'Establish yourself as a recognised voice in logistics. Your author profile reaches thousands of industry peers each month.',
                'sort_order' => 2,
            ],
            [
                'title'      => 'Reach a Targeted Audience',
                'body'       => 'Your content goes directly to logistics professionals, executives, and decision-makers who are actively seeking your expertise.',
                'sort_order' => 3,
            ],
        ];

        foreach ($pillars as $data) {
            ExpertDeskPillar::create($data);
        }
    }
}
