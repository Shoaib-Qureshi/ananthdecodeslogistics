<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContributorPost extends Model
{
    use HasFactory;

    public const DEFAULT_FEATURED_IMAGE = 'img/thumbnail/Default_Contributor_img.webp';

    protected $table = 'contributor_posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'featured_image',
        'is_featured',
        'feature_source_plan',
        'has_faqs',
        'faqs',
        'status',
        'rejection_reason',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
        'robots_index',
        'robots_follow',
        'schema_json_ld',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'has_faqs' => 'boolean',
        'faqs' => 'array',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategories::class, 'category_id');
    }

    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'approved'  => 'success',
            'published' => 'primary',
            'rejected'  => 'danger',
            default     => 'secondary',
        };
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->featured_image
            ? asset('storage/posts/' . $this->featured_image)
            : asset(self::DEFAULT_FEATURED_IMAGE);
    }
}
