<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('venue_name')->nullable()->after('location');
            $table->text('venue_address')->nullable()->after('venue_name');
            $table->text('venue_map_embed')->nullable()->after('venue_address');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['venue_name', 'venue_address', 'venue_map_embed']);
        });
    }
};
