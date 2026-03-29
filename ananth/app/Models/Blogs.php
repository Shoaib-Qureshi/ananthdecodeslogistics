<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $table = 'blogs';

    protected array $editorialAuthorNames = [
        'Ananthakrishnan J',
        'Ananthakrishnan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategories::class, 'category_id');
    }

    public function scopeEditorialByAnanth($query)
    {
        $authorNames = $this->editorialAuthorNames;

        return $query->whereHas('user', function ($userQuery) use ($authorNames) {
            $userQuery->whereIn('name', $authorNames);
        });
    }
}
