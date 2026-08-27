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
            if (! Schema::hasColumn('events', 'registrations_open')) {
                $table->boolean('registrations_open')->default(true)->after('registration_steps');
            }

            if (! Schema::hasColumn('events', 'registrations_closed_message')) {
                $table->text('registrations_closed_message')->nullable()->after('registrations_open');
            }
        });

        // Events created from here on default to open; the events that already
        // exist are closed, which is the state this change was introduced for.
        // Re-open any of them from Admin > Events > Registration Page Content.
        DB::table('events')->update(['registrations_open' => false]);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            foreach (['registrations_closed_message', 'registrations_open'] as $column) {
                if (Schema::hasColumn('events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
