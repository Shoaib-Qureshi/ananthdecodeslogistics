<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Founder;

class FounderSeeder extends Seeder
{
    public function run()
    {
        $founders = [
            [
                'sort_order' => 1,
                'eyebrow'    => 'THE FOUNDER',
                'name'       => 'Dr. Ananthakrishnan Janardhanan',
                'title'      => 'Founder & Director, Ananth Decodes Logistics Private Limited',
                'bio'        => 'A seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management. Dr. Ananth has held senior leadership roles across multinational organisations, driving operational excellence, strategic growth, and thought leadership across the Indian logistics landscape. He founded ADL to create a credible, practitioner-led knowledge platform for the sector.',
                'visible'    => true,
            ],
            [
                'sort_order' => 2,
                'eyebrow'    => 'THE CO-FOUNDER',
                'name'       => 'Ms. Annapoorna Yadav TP',
                'title'      => 'Co-Founder & Managing Director, Ananth Decodes Logistics Private Limited',
                'bio'        => 'A dynamic business leader with deep expertise in operations management, strategic partnerships, and organisational development. Ms. Annapoorna brings sharp commercial acumen and a passion for building scalable, impact-driven ventures. As Co-Founder and Managing Director, she leads ADL\'s day-to-day operations, partnerships, and growth strategy.',
                'visible'    => true,
            ],
        ];

        foreach ($founders as $data) {
            Founder::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
