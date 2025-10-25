<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index()
    {
        $blogs = Blog::published()
                    ->with(['category', 'tags'])
                    ->latest('published_at')
                    ->paginate(12);

        return view('pages.blog.index', compact('blogs'));
    }

    /**
     * Display a single blog post
     */
    public function show($slug)
    {
        $blog = Blog::published()
                   ->with(['category', 'tags', 'approvedComments'])
                   ->where('slug', $slug)
                   ->firstOrFail();

        // Increment views
        $blog->incrementViews();

        // Get related posts
        $relatedPosts = $blog->getRelatedPosts(3);

        // Get prev/next blogs
        $previousBlog = Blog::published()
                           ->where('published_at', '<', $blog->published_at)
                           ->latest('published_at')
                           ->first();

        $nextBlog = Blog::published()
                       ->where('published_at', '>', $blog->published_at)
                       ->oldest('published_at')
                       ->first();

        return view('pages.blog.details', compact('blog', 'relatedPosts', 'previousBlog', 'nextBlog'));
    }

    /**
     * Filter blogs by category
     */
    public function byCategory($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $blogs = Blog::published()
                    ->where('blog_category_id', $category->id)
                    ->with(['category', 'tags'])
                    ->latest('published_at')
                    ->paginate(12);

        return view('pages.blog.category', compact('blogs', 'category'));
    }

    /**
     * Filter blogs by tag
     */
    public function byTag($slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $blogs = $tag->blogs()
                    ->published()
                    ->with(['category', 'tags'])
                    ->latest('published_at')
                    ->paginate(12);

        return view('pages.blog.tag', compact('blogs', 'tag'));
    }

    /**
     * Store a new comment
     */
    public function storeComment(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = $blog->comments()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Requires approval
        ]);

        return redirect()
            ->route('blog.details', $slug)
            ->with('success', 'Thank you for your comment! It will be published after review.');
    }
}
