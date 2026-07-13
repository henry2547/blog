<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category',
        'tags',
        'status',
        'published_at',
        'views',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'views' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where('status', 'draft')->where('user_id', Auth::id() ?? 0);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        if ($this->status === 'published') {
            return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-900 dark:text-green-300">Published</span>';
        }
        return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/40 text-yellow-900 dark:text-yellow-300">Draft</span>';
    }

    // Mutators
    public static function generateSlug(string $title): string
    {
        return Str::slug($title) . '-' . Str::random(8);
    }
}

