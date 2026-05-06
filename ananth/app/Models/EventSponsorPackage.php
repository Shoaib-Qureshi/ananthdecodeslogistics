<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSponsorPackage extends Model
{
    protected $fillable = [
        'event_id', 'name', 'slug', 'slot_count', 'price_inr', 'price_usd',
        'included_passes', 'description', 'benefits', 'sort_order', 'visible',
    ];

    protected $casts = [
        'price_inr' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'benefits' => 'array',
        'visible' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function priceForCurrency(string $currency): float
    {
        return strtoupper($currency) === 'USD' ? (float) $this->price_usd : (float) $this->price_inr;
    }

    public function formattedPrice(string $currency): string
    {
        $amount = $this->priceForCurrency($currency);

        if (strtoupper($currency) === 'USD') {
            return '$' . number_format($amount, 0);
        }

        return 'INR ' . number_format($amount, 0);
    }
}
