<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('gallery_images')->exists()) {
            return;
        }

        $items = [
            [
                'title' => 'Supply Chain Strategy',
                'category' => 'Boardroom',
                'image' => '/img/site/anantha-home-banner.jpg',
                'caption' => 'Strategy-led logistics conversations shaped for decision makers.',
            ],
            [
                'title' => 'Operational Intelligence',
                'category' => 'Logistics',
                'image' => '/img/site/generative-ai-is-used-transport-goods.jpg',
                'caption' => 'Modern mobility, freight, and data-led operational thinking.',
            ],
            [
                'title' => 'Field Perspectives',
                'category' => 'Expert Desk',
                'image' => '/img/site/truck-bg-img-1.webp',
                'caption' => 'Ideas from practitioners who understand execution at ground level.',
            ],
            [
                'title' => 'Leadership Notes',
                'category' => 'People',
                'image' => '/img/site/founder.jpeg',
                'caption' => 'Ananth Decodes Logistics through conversations, sessions, and industry notes.',
            ],
            [
                'title' => 'Logistics Networks',
                'category' => 'Infrastructure',
                'image' => '/img/site/Universal-Logistics-Customs-Brokerage-Services-2.jpeg',
                'caption' => 'Ports, customs, freight movement, and the networks behind growth.',
            ],
            [
                'title' => 'Future Systems',
                'category' => 'Innovation',
                'image' => '/img/site/anantha-logistics.webp',
                'caption' => 'Technology, resilience, and the next decade of supply chains.',
            ],
        ];

        foreach ($items as $index => $item) {
            DB::table('gallery_images')->insert($item + [
                'sort_order' => $index + 1,
                'visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('gallery_images')
            ->whereIn('image', [
                '/img/site/anantha-home-banner.jpg',
                '/img/site/generative-ai-is-used-transport-goods.jpg',
                '/img/site/truck-bg-img-1.webp',
                '/img/site/founder.jpeg',
                '/img/site/Universal-Logistics-Customs-Brokerage-Services-2.jpeg',
                '/img/site/anantha-logistics.webp',
            ])
            ->delete();
    }
};
