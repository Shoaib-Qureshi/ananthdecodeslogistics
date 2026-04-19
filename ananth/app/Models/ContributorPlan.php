<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_public',
        'name',
        'admin_name',
        'price',
        'currency',
        'price_label',
        'duration_months',
        'duration_label',
        'max_posts',
        'post_limit_label',
        'homepage_feature',
        'summary',
        'highlights',
        'checkout_name',
        'checkout_description',
        'success_label',
        'success_note',
        'renew_cta',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'price' => 'integer',
        'duration_months' => 'integer',
        'max_posts' => 'integer',
        'homepage_feature' => 'boolean',
        'highlights' => 'array',
    ];

    public function toSupportArray(): array
    {
        return [
            'code' => $this->code,
            'public' => (bool) $this->is_public,
            'name' => $this->name,
            'admin_name' => $this->admin_name,
            'price' => (int) $this->price,
            'currency' => (string) $this->currency,
            'price_label' => $this->price_label,
            'duration_months' => $this->duration_months,
            'duration_label' => $this->duration_label,
            'max_posts' => $this->max_posts,
            'post_limit_label' => $this->post_limit_label,
            'homepage_feature' => (bool) $this->homepage_feature,
            'summary' => $this->summary,
            'highlights' => is_array($this->highlights) ? $this->highlights : [],
            'checkout_name' => $this->checkout_name,
            'checkout_description' => $this->checkout_description,
            'success_label' => $this->success_label,
            'success_note' => $this->success_note,
            'renew_cta' => $this->renew_cta,
        ];
    }
}
