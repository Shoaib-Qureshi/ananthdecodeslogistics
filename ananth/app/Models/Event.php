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
        'sponsor_intro', 'sponsor_benefits', 'sponsor_inclusions', 'contact_email', 'contact_note', 'closing_note',
        'why_who_eyebrow', 'why_who_heading', 'why_who_subheading',
        'sponsorship_eyebrow', 'sponsorship_heading', 'sponsorship_subheading',
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

    public static function slugifyPackage(string $name): string
    {
        return Str::slug($name) ?: 'package';
    }
}
