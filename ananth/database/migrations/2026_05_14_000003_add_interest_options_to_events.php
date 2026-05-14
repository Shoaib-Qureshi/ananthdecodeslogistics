<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterestOptionsToEvents extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('events')) {
            return;
        }

        if (!Schema::hasColumn('events', 'interest_options')) {
            Schema::table('events', function (Blueprint $table) {
                $table->json('interest_options')->nullable()->after('contact_note');
            });
        }

        Event::query()->whereNull('interest_options')->update([
            'interest_options' => json_encode(Event::defaultInterestOptions()),
        ]);
    }

    public function down()
    {
        if (!Schema::hasTable('events') || !Schema::hasColumn('events', 'interest_options')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('interest_options');
        });
    }
}
