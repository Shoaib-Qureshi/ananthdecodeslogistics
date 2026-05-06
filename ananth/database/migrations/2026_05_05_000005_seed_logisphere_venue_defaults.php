<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('events')
            ->where(function ($query) {
                $query->whereNull('venue_name')->orWhere('venue_name', '');
            })
            ->update([
                'venue_name' => 'CMA Grand Convention & Wedding Hall',
                'venue_address' => '19th Bazar Street, Arabic College Post, Bengaluru',
                'venue_map_embed' => 'https://www.google.com/maps?q=CMA%20Grand%20Convention%20%26%20Wedding%20Hall%20Bengaluru&output=embed',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('events')
            ->where('venue_name', 'CMA Grand Convention & Wedding Hall')
            ->update([
                'venue_name' => null,
                'venue_address' => null,
                'venue_map_embed' => null,
                'updated_at' => now(),
            ]);
    }
};
