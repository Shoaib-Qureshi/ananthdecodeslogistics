<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('events', 'marketing_partners')) {
            Schema::table('events', function (Blueprint $table) {
                $table->json('marketing_partners')->nullable()->after('delegate_logos');
            });
        }

        $partners = [
            [
                'name' => 'NeuWork Solutions',
                'role' => 'Marketing & Execution Partners',
                'logo' => '/img/events/marketing-partners/neuwork-solutions.jpg',
            ],
            [
                'name' => '360 Degree Media',
                'role' => 'Marketing & Media Partners',
                'logo' => '/img/events/marketing-partners/360-media-exchange.jpg',
            ],
            [
                'name' => 'Leveragez',
                'role' => 'Marketing & Delegate Management Partners',
                'logo' => '/img/events/marketing-partners/leveragez-marketing.jpg',
            ],
        ];

        $event = Event::where('is_active', true)->first() ?? Event::orderBy('id')->first();
        if ($event && ! $event->marketing_partners) {
            $event->update(['marketing_partners' => $partners]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('events', 'marketing_partners')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('marketing_partners');
            });
        }
    }
};
