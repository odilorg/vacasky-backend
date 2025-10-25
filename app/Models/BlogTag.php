<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Boot method - auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Relationship: Tag belongs to many blogs (many-to-many)
     */
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_tag');
    }

    /**
     * Get published blogs count
     */
    public function getPublishedBlogsCount()
    {
        return $this->blogs()->published()->count();
    }
}
