<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'slug', 'name', 'chapter', 'tagline', 'event_date', 'event_time', 'location', 'venue_name', 'venue_address', 'venue_map_embed', 'format', 'hero_image',
        'welcome_note', 'about', 'why_now', 'theme_title', 'theme_points', 'comparison_rows', 'attendee_profiles',
        'exhibitor_intro', 'exhibitor_benefits', 'exhibitor_profile', 'exhibitor_package_notes',
        'sponsor_intro', 'sponsor_benefits', 'sponsor_inclusions', 'contact_email', 'contact_note', 'interest_options', 'closing_note',
        'why_who_eyebrow', 'why_who_heading', 'why_who_subheading',
        'sponsorship_eyebrow', 'sponsorship_heading', 'sponsorship_subheading',
        'registration_eyebrow', 'registration_heading', 'registration_subheading',
        'registration_panel_eyebrow', 'registration_panel_heading',
        'registration_form_heading', 'registration_form_subheading', 'registration_steps',
        'active_sponsor_currency', 'tax_label', 'tax_percentage', 'is_active',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $casts = [
        'event_date' => 'date',
        'theme_points' => 'array',
        'comparison_rows' => 'array',
        'attendee_profiles' => 'array',
        'exhibitor_benefits' => 'array',
        'exhibitor_package_notes' => 'array',
        'sponsor_benefits' => 'array',
        'sponsor_inclusions' => 'array',
        'interest_options' => 'array',
        'registration_steps' => 'array',
        'tax_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function agendaItems()
    {
        return $this->hasMany(EventAgendaItem::class)->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->hasMany(EventFaq::class)->orderBy('sort_order');
    }

    public function sponsorPackages()
    {
        return $this->hasMany(EventSponsorPackage::class)->orderBy('sort_order');
    }

    public static function past(): \Illuminate\Database\Eloquent\Collection
    {
        return static::whereNotNull('event_date')
            ->where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->get();
    }

    public static function upcoming(): \Illuminate\Database\Eloquent\Collection
    {
        return static::whereNotNull('event_date')
            ->where('event_date', '>', now())
            ->where('is_active', false)
            ->orderBy('event_date')
            ->get();
    }

    public static function current(): self
    {
        return static::where('is_active', true)->orderBy('id')->first()
            ?? static::orderBy('id')->first()
            ?? static::create([
                'slug' => 'logisphere-bengaluru-2026',
                'name' => 'LOGISPHERE',
                'chapter' => 'Chapter 1: Bengaluru Edition',
                'tagline' => 'One Sphere. Infinite Supply Chain Possibilities.',
                'active_sponsor_currency' => 'INR',
            ]);
    }

    public function activeCurrency(): string
    {
        return strtoupper($this->active_sponsor_currency ?: 'INR') === 'USD' ? 'USD' : 'INR';
    }

    public function formattedDate(): string
    {
        return $this->event_date ? $this->event_date->format('jS F Y') : '7th August 2026';
    }

    public function publicTitle(): string
    {
        return trim($this->name . ' ' . ($this->chapter ? '- ' . $this->chapter : ''));
    }

    public static function defaultInterestOptions(): array
    {
        return [
            ['value' => 'delegate', 'label' => 'Delegate'],
            ['value' => 'speaker', 'label' => 'Speaker'],
            ['value' => 'sponsor', 'label' => 'Sponsor'],
            ['value' => 'exhibitor', 'label' => 'Exhibitor'],
        ];
    }

    public function interestOptions(): array
    {
        $options = is_array($this->interest_options) ? $this->interest_options : [];
        $normalized = [];

        foreach ($options as $key => $option) {
            if (is_array($option)) {
                $label = trim((string) ($option['label'] ?? ''));
                $value = trim((string) ($option['value'] ?? ''));
            } else {
                $label = trim((string) $option);
                $value = is_string($key) ? trim($key) : '';
            }

            if ($label === '') {
                continue;
            }

            $value = $value !== '' ? Str::slug($value, '_') : Str::slug($label, '_');
            if ($value === '') {
                continue;
            }

            $normalized[$value] = ['value' => $value, 'label' => $label];
        }

        return array_values($normalized ?: static::defaultInterestOptions());
    }

    public function interestOptionMap(): array
    {
        $map = [];

        foreach ($this->interestOptions() as $option) {
            $map[$option['value']] = $option['label'];
        }

        return $map;
    }

    public static function defaultRegistrationSteps(): array
    {
        return [
            ['title' => 'Submit your interest', 'text' => 'Choose delegate, speaker, sponsor, or exhibitor and share basic details.'],
            ['title' => 'Team review', 'text' => 'The LogiSphere team checks fit and follows up with the right next step.'],
            ['title' => 'Confirmation', 'text' => 'Approved delegates and partners receive event coordination details.'],
        ];
    }

    public function registrationSteps(): array
    {
        $steps = is_array($this->registration_steps) ? $this->registration_steps : [];
        $normalized = [];

        foreach ($steps as $step) {
            $title = trim((string) ($step['title'] ?? ''));
            $text = trim((string) ($step['text'] ?? ''));

            if ($title === '' && $text === '') {
                continue;
            }

            $normalized[] = ['title' => $title, 'text' => $text];
        }

        return $normalized ?: static::defaultRegistrationSteps();
    }

    public static function slugifyPackage(string $name): string
    {
        return Str::slug($name) ?: 'package';
    }
}
