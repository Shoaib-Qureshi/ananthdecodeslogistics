<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRegistrationCopyToEvents extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('events')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'registration_eyebrow')) {
                $table->string('registration_eyebrow')->nullable();
                $table->string('registration_heading')->nullable()->after('registration_eyebrow');
                $table->text('registration_subheading')->nullable()->after('registration_heading');
                $table->string('registration_panel_eyebrow')->nullable()->after('registration_subheading');
                $table->string('registration_panel_heading')->nullable()->after('registration_panel_eyebrow');
                $table->string('registration_form_heading')->nullable()->after('registration_panel_heading');
                $table->text('registration_form_subheading')->nullable()->after('registration_form_heading');
                $table->json('registration_steps')->nullable()->after('registration_form_subheading');
            }
        });

        DB::table('events')->whereNull('registration_heading')->update([
            'registration_eyebrow' => 'Register',
            'registration_heading' => 'Register for LogiSphere',
            'registration_subheading' => 'Share your interest as a delegate, speaker, sponsor, or exhibitor.',
            'registration_panel_eyebrow' => 'Contact Information',
            'registration_panel_heading' => 'The event team will follow up.',
            'registration_form_heading' => 'Register Interest',
            'registration_form_subheading' => 'Tell us how you want to participate in LogiSphere.',
            'registration_steps' => json_encode(Event::defaultRegistrationSteps()),
        ]);
    }

    public function down()
    {
        if (!Schema::hasTable('events') || !Schema::hasColumn('events', 'registration_eyebrow')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'registration_eyebrow',
                'registration_heading',
                'registration_subheading',
                'registration_panel_eyebrow',
                'registration_panel_heading',
                'registration_form_heading',
                'registration_form_subheading',
                'registration_steps',
            ]);
        });
    }
}
