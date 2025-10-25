<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Relationship: Comment belongs to a blog
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Scope: Only approved comments
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Approve this comment
     */
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * Reject/Unapprove this comment
     */
    public function reject()
    {
        $this->update(['is_approved' => false]);
    }
}
