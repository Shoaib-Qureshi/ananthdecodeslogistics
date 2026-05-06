<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'why_who_eyebrow')) {
                $table->string('why_who_eyebrow')->nullable()->after('why_now');
                $table->string('why_who_heading')->nullable()->after('why_who_eyebrow');
                $table->text('why_who_subheading')->nullable()->after('why_who_heading');
                $table->string('sponsorship_eyebrow')->nullable()->after('sponsor_inclusions');
                $table->string('sponsorship_heading')->nullable()->after('sponsorship_eyebrow');
                $table->text('sponsorship_subheading')->nullable()->after('sponsorship_heading');
            }
        });

        DB::table('events')->whereNull('why_who_heading')->update([
            'why_who_eyebrow' => 'Why LogiSphere',
            'why_who_heading' => 'Why now? Why Bengaluru?',
            'why_who_subheading' => 'Bengaluru is the natural birthplace for Chapter 1.',
            'sponsorship_eyebrow' => 'Sponsor & Exhibit',
            'sponsorship_heading' => 'Partner with LogiSphere',
            'sponsorship_subheading' => 'Paid sponsorship packages for brands that want precise access to supply chain decision-makers.',
        ]);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'why_who_eyebrow')) {
                $table->dropColumn([
                    'why_who_eyebrow',
                    'why_who_heading',
                    'why_who_subheading',
                    'sponsorship_eyebrow',
                    'sponsorship_heading',
                    'sponsorship_subheading',
                ]);
            }
        });
    }
};
