<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('events', 'marketing_partners')) {
            return;
        }

        Event::query()->each(function (Event $event) {
            $updates = [];

            $partners = collect($event->marketing_partners ?: [])
                ->map(function ($partner) {
                    if (! is_array($partner)) {
                        return $partner;
                    }

                    $partner['logo'] = $this->normalizeUrl($partner['logo'] ?? '');
                    return $partner;
                })
                ->values()
                ->all();

            if ($partners !== ($event->marketing_partners ?: [])) {
                $updates['marketing_partners'] = $partners;
            }

            if (Schema::hasColumn('events', 'delegate_logos')) {
                $delegateLogos = collect($event->delegate_logos ?: [])
                    ->map(fn ($logo) => is_string($logo) ? $this->normalizeUrl($logo) : $logo)
                    ->values()
                    ->all();

                if ($delegateLogos !== ($event->delegate_logos ?: [])) {
                    $updates['delegate_logos'] = $delegateLogos;
                }
            }

            if ($updates) {
                $event->update($updates);
            }
        });
    }

    public function down(): void
    {
        // Relative storage URLs are valid in every environment and should not be reverted.
    }

    private function normalizeUrl(?string $url): string
    {
        $url = trim((string) $url);
        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && str_starts_with($path, '/storage/') ? $path : $url;
    }
};
