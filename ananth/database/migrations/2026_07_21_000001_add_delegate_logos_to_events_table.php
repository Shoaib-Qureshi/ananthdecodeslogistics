<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('events', 'delegate_logos')) {
            Schema::table('events', function (Blueprint $table) {
                $table->json('delegate_logos')->nullable()->after('attendee_profiles');
            });
        }

        $files = glob(public_path('img/events/delegates/delegate-*.jpg')) ?: [];
        sort($files, SORT_NATURAL);
        $logos = array_values(array_map(
            fn (string $path): string => '/img/events/delegates/' . basename($path),
            $files
        ));

        if (! $logos) {
            return;
        }

        $event = Event::where('is_active', true)->first() ?? Event::orderBy('id')->first();
        if ($event && ! $event->delegate_logos) {
            $event->update(['delegate_logos' => $logos]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('events', 'delegate_logos')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('delegate_logos');
            });
        }
    }
};
