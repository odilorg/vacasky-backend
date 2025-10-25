<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'blog_category_id',
        'author_name',
        'author_avatar',
        'author_bio',
        'reading_time',
        'views_count',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    /**
     * Boot method - auto-generate slug and calculate reading time
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }

            if (empty($blog->reading_time)) {
                $blog->reading_time = $blog->calculateReadingTime();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }

            if ($blog->isDirty('content')) {
                $blog->reading_time = $blog->calculateReadingTime();
            }
        });
    }

    /**
     * Relationship: Blog belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Relationship: Blog has many comments
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Relationship: Blog has many approved comments
     */
    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class)->where('is_approved', true)->latest();
    }

    /**
     * Relationship: Blog has many tags (many-to-many)
     */
    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_blog_tag');
    }

    /**
     * Scope: Only published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope: Search blogs by keyword
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('excerpt', 'like', "%{$keyword}%")
              ->orWhere('content', 'like', "%{$keyword}%");
        });
    }

    /**
     * Calculate reading time based on content
     * Average reading speed: 200 words per minute
     */
    public function calculateReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return max($minutes, 1); // Minimum 1 minute
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get related posts (same category, exclude current)
     */
    public function getRelatedPosts($limit = 3)
    {
        return self::published()
                   ->where('id', '!=', $this->id)
                   ->where('blog_category_id', $this->blog_category_id)
                   ->latest('published_at')
                   ->limit($limit)
                   ->get();
    }

    /**
     * Get excerpt or generate from content
     */
    public function getExcerptAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        // Generate excerpt from content if not set
        return Str::limit(strip_tags($this->content), 160);
    }

    /**
     * Get SEO meta title or use title
     */
    public function getSeoTitle()
    {
        return $this->meta_title ?: $this->title . ' | Vacasky Blog';
    }

    /**
     * Get SEO meta description or use excerpt
     */
    public function getSeoDescription()
    {
        return $this->meta_description ?: $this->excerpt;
    }

    /**
     * Get formatted published date
     */
    public function getPublishedDate()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : null;
    }

    /**
     * Get human-readable published date
     */
    public function getPublishedDateHuman()
    {
        return $this->published_at ? $this->published_at->diffForHumans() : null;
    }
}
