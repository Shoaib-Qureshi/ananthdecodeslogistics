<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FounderCredential;

class FounderCredentialSeeder extends Seeder
{
    public function run()
    {
        if (FounderCredential::count() > 0) {
            return;
        }

        $credentials = [
            ['credential' => '25+ Years in Transport, Logistics & Facility Management', 'sort_order' => 1],
            ['credential' => 'Former Senior Executive — Multi-National Logistics Operations', 'sort_order' => 2],
            ['credential' => 'Strategic Leader — Supply Chain Transformation & Innovation', 'sort_order' => 3],
            ['credential' => 'Published Author & Recognised Industry Thought Leader', 'sort_order' => 4],
            ['credential' => 'Founder, Ananth Decodes Logistics Private Limited', 'sort_order' => 5],
        ];

        foreach ($credentials as $data) {
            FounderCredential::create($data);
        }
    }
}
