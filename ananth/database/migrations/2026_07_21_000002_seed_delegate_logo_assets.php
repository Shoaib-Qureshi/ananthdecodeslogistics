<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
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
        if (! $event) {
            return;
        }

        $existing = collect($event->delegate_logos ?: [])
            ->map(fn ($logo) => is_array($logo) ? ($logo['url'] ?? null) : $logo)
            ->filter()
            ->values();

        $event->update([
            'delegate_logos' => $existing
                ->map(fn ($logo) => str_replace('/storage/events/delegates/', '/img/events/delegates/', $logo))
                ->merge($logos)
                ->unique()
                ->values()
                ->all(),
        ]);
    }

    public function down(): void
    {
        // Delegate logo content is managed data; leave it intact on rollback.
    }
};
