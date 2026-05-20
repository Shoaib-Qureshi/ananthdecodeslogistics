<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('events') || ! Schema::hasTable('event_agenda_items')) {
            return;
        }

        $event = DB::table('events')->where('slug', 'logisphere-bengaluru-2026')->first()
            ?? DB::table('events')->where('name', 'LOGISPHERE')->orderBy('id')->first();

        if (! $event) {
            return;
        }

        $now = now();

        DB::table('event_agenda_items')->where('event_id', $event->id)->delete();

        $agenda = [
            ['09:30 AM', '10:00 AM', '30 minutes', null, 'Registration', null],
            ['10:00 AM', '10:05 AM', '5 minutes', null, 'Welcome Address', null],
            ['10:05 AM', '10:15 AM', '10 minutes', null, 'About Ananth Decodes Logistics', null],
            ['10:15 AM', '11:00 AM', '45 minutes', 'Seminar', 'From Cost Center to Strategic Engine: Repositioning Logistics in the Boardroom', 'Focus on how logistics is no longer a support function but a driver of growth, resilience, and competitive advantage.'],
            ['11:00 AM', '11:10 AM', '10 minutes', null, 'Sponsor 1', null],
            ['11:10 AM', '11:40 AM', '30 minutes', 'Panel Discussion 1', 'Speed vs Profitability: Are We Scaling Inefficiencies?', null],
            ['11:40 AM', '11:50 AM', '10 minutes', null, 'Sponsor 2', null],
            ['11:50 AM', '12:20 PM', '30 minutes', 'Panel Discussion 2', 'India as a Global Supply Chain Hub: Opportunity or Overstatement?', null],
            ['12:20 PM', '12:30 PM', '10 minutes', null, 'Sponsor 3', null],
            ['12:30 PM', '01:00 PM', '30 minutes', 'Panel Discussion 3', 'Platform Economy vs Traditional Logistics Models: Who Will Win?', null],
            ['01:00 PM', '01:10 PM', '10 minutes', null, 'Sponsor 4', null],
            ['01:10 PM', '02:10 PM', '60 minutes', null, 'Networking Lunch & Exhibition Visit', '40 stalls open.'],
            ['02:10 PM', '02:20 PM', '10 minutes', null, 'Sponsor 5', null],
            ['02:20 PM', '03:05 PM', '45 minutes', 'Seminar', 'The Next Decade of Supply Chains: Digital, Decentralized, and Sustainable', 'Covers AI, platform ecosystems, green logistics, and the shift from linear to networked supply chains.'],
            ['03:05 PM', '03:15 PM', '10 minutes', null, 'Sponsor 6', null],
            ['03:15 PM', '03:45 PM', '30 minutes', 'Panel Discussion 1', 'CEO, COO, and CSCO Alignment: Why Strategy Breaks in Execution', null],
            ['03:45 PM', '03:55 PM', '10 minutes', null, 'Sponsor 7', null],
            ['03:55 PM', '04:25 PM', '30 minutes', 'Panel Discussion 2', 'The Talent Crisis in Logistics: Skill Gap or Mindset Gap?', null],
            ['04:25 PM', '04:35 PM', '10 minutes', null, 'Sponsor 8', null],
            ['04:35 PM', '05:05 PM', '30 minutes', 'Panel Discussion 3', 'Sustainability in Supply Chains: Compliance Burden or Business Opportunity?', null],
            ['05:05 PM', '05:15 PM', '10 minutes', null, 'Sponsor 9', null],
            ['05:15 PM', '05:45 PM', '30 minutes', null, 'Exhibition & High-Value Networking', '40 stalls active.'],
            ['05:45 PM', '06:30 PM', '45 minutes', null, 'Momento Distribution', null],
            ['06:30 PM', '07:00 PM', '30 minutes', null, 'Closing Remarks & Key Takeaways', null],
            ['07:00 PM', '10:00 PM', '180 minutes', null, 'Cocktail Dinner & Premium Networking', null],
        ];

        foreach ($agenda as $index => [$start, $end, $duration, $type, $title, $description]) {
            DB::table('event_agenda_items')->insert([
                'event_id' => $event->id,
                'start_time' => $start,
                'end_time' => $end,
                'duration' => $duration,
                'session_type' => $type,
                'title' => $title,
                'description' => $description,
                'sort_order' => $index,
                'visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Content-only migration. Do not restore older inferred agenda data.
    }
};
