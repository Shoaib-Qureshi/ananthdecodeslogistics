<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('events')
            ->where(function ($query) {
                $query->where('venue_map_embed', 'like', '%CMA%Grand%Convention%')
                    ->orWhere('venue_address', 'like', '%Venue Address%');
            })
            ->update([
                'venue_name' => 'CMA Grand Convention & Wedding Hall',
                'venue_address' => '19th Bazar Street, Arabic College Post, Bengaluru',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Keep admin-edited venue content intact on rollback.
    }
};
