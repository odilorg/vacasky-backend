@extends('layouts.app')

{{-- SEO Meta Tags --}}
@section('title')
{{ $blog->getSeoTitle() }}
@endsection

@section('meta_description')
{{ $blog->getSeoDescription() }}
@endsection

@section('meta_keywords')
{{ $blog->meta_keywords ?? 'travel blog, vacation tips, travel guides' }}
@endsection

@section('canonical_url')
{{ route('blog.details', $blog->slug) }}
@endsection

{{-- Open Graph / Facebook --}}
@section('og_type')
article
@endsection

@section('og_title')
{{ $blog->meta_title ?? $blog->title }}
@endsection

@section('og_description')
{{ $blog->getSeoDescription() }}
@endsection

@section('og_image')
{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('vacasky/images/logo.png') }}
@endsection

@section('og_url')
{{ route('blog.details', $blog->slug) }}
@endsection

{{-- Twitter Card --}}
@section('twitter_title')
{{ $blog->meta_title ?? $blog->title }}
@endsection

@section('twitter_description')
{{ $blog->getSeoDescription() }}
@endsection

@section('twitter_image')
{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('vacasky/images/logo.png') }}
@endsection

@section('twitter_url')
{{ route('blog.details', $blog->slug) }}
@endsection

{{-- Schema.org JSON-LD for Blog Posts --}}
@push('styles')
<script type="application/ld+json">
@php
$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $blog->title,
    'description' => strip_tags($blog->excerpt),
    'image' => $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('vacasky/images/logo.png'),
    'datePublished' => $blog->published_at ? $blog->published_at->toIso8601String() : now()->toIso8601String(),
    'dateModified' => $blog->updated_at->toIso8601String(),
    'author' => [
        '@type' => 'Person',
        'name' => $blog->author_name
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Vacasky',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('vacasky/images/logo.png')
        ]
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => route('blog.details', $blog->slug)
    ]
];

if ($blog->category) {
    $jsonLd['articleSection'] = $blog->category->name;
}

if ($blog->tags && $blog->tags->count() > 0) {
    $jsonLd['keywords'] = $blog->tags->pluck('name')->implode(', ');
}

echo json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
@endphp
</script>
@endpush

@section('content')

	<!-- Page Banner -->
	<section class="page-banner" style="background-image: url({{ asset('vacasky/images/background/15.jpg') }})">
		<div class="auto-container">
			<ul class="page-breadbrumbs">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li><a href="{{ route('blog.index') }}">Blog</a></li>
				@if($blog->category)
					<li><a href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a></li>
				@endif
				<li>{{ $blog->title }}</li>
			</ul>
			<h1 class="page-banner_title">{{ strtoupper($blog->title) }}</h1>
		</div>
	</section>
	<!-- End Page Banner -->

	<!-- Blog Detail Section -->
	<section class="blog-detail-section">
		<div class="auto-container">
			<div class="row clearfix">
				<!-- Content Column -->
				<div class="col-lg-8 col-md-12 col-sm-12">
					<!-- Blog Detail -->
					<div class="blog-detail">
						<!-- Featured Image -->
						@if($blog->featured_image)
							<div class="blog-detail_image">
								<img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" />
							</div>
						@endif

						<!-- Blog Meta -->
						<div class="blog-detail_meta">
							<ul class="blog-detail_meta-list">
								<li><i class="fa fa-calendar"></i> {{ $blog->getPublishedDate() }}</li>
								@if($blog->category)
									<li>
										<i class="fa fa-folder"></i>
										<a href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a>
									</li>
								@endif
								<li><i class="fa fa-clock"></i> {{ $blog->reading_time }} min read</li>
								<li><i class="fa fa-eye"></i> {{ number_format($blog->views_count) }} views</li>
							</ul>
						</div>

						<!-- Blog Content -->
						<div class="blog-detail_content">
							{!! $blog->content !!}
						</div>

						<!-- Tags -->
						@if($blog->tags && $blog->tags->count() > 0)
							<div class="blog-detail_tags">
								<strong>Tags:</strong>
								@foreach($blog->tags as $tag)
									<a href="{{ route('blog.tag', $tag->slug) }}" class="tag-badge">{{ $tag->name }}</a>
								@endforeach
							</div>
						@endif

						<!-- Author Card -->
						<div class="blog-detail_author">
							<div class="author-inner">
								@if($blog->author_avatar)
									<div class="author-image">
										<img src="{{ asset('storage/' . $blog->author_avatar) }}" alt="{{ $blog->author_name }}" />
									</div>
								@else
									<div class="author-image">
										<div class="author-placeholder">{{ substr($blog->author_name, 0, 1) }}</div>
									</div>
								@endif
								<div class="author-content">
									<h4>{{ $blog->author_name }}</h4>
									@if($blog->author_bio)
										<p>{{ $blog->author_bio }}</p>
									@endif
								</div>
							</div>
						</div>

						<!-- Prev/Next Navigation -->
						@if($previousBlog || $nextBlog)
							<div class="blog-detail_navigation">
								<div class="row clearfix">
									@if($previousBlog)
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="nav-item prev-post">
												<a href="{{ route('blog.details', $previousBlog->slug) }}">
													<span class="nav-label"><i class="fa fa-arrow-left"></i> Previous Post</span>
													<span class="nav-title">{{ $previousBlog->title }}</span>
												</a>
											</div>
										</div>
									@endif
									@if($nextBlog)
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="nav-item next-post">
												<a href="{{ route('blog.details', $nextBlog->slug) }}">
													<span class="nav-label">Next Post <i class="fa fa-arrow-right"></i></span>
													<span class="nav-title">{{ $nextBlog->title }}</span>
												</a>
											</div>
										</div>
									@endif
								</div>
							</div>
						@endif

						<!-- Related Posts -->
						@if($relatedPosts && $relatedPosts->count() > 0)
							<div class="blog-detail_related">
								<h3>Related Articles</h3>
								<div class="row clearfix">
									@foreach($relatedPosts as $relatedPost)
										<div class="col-lg-4 col-md-6 col-sm-12">
											<div class="related-post-item">
												@if($relatedPost->featured_image)
													<div class="related-post-image">
														<a href="{{ route('blog.details', $relatedPost->slug) }}">
															<img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" />
														</a>
													</div>
												@endif
												<div class="related-post-content">
													<h4>
														<a href="{{ route('blog.details', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
													</h4>
													<div class="related-post-meta">
														<span><i class="fa fa-calendar"></i> {{ $relatedPost->getPublishedDate() }}</span>
														<span><i class="fa fa-clock"></i> {{ $relatedPost->reading_time }} min</span>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endif

						<!-- Comments Section -->
						<div class="blog-detail_comments">
							<h3>Comments ({{ $blog->approvedComments->count() }})</h3>

							<!-- Display Comments -->
							@if($blog->approvedComments->count() > 0)
								<div class="comments-list">
									@foreach($blog->approvedComments as $comment)
										<div class="comment-item">
											<div class="comment-avatar">
												<div class="avatar-placeholder">{{ substr($comment->name, 0, 1) }}</div>
											</div>
											<div class="comment-content">
												<h5>{{ $comment->name }}</h5>
												<div class="comment-meta">
													<span><i class="fa fa-clock"></i> {{ $comment->created_at->diffForHumans() }}</span>
												</div>
												<p>{{ $comment->comment }}</p>
											</div>
										</div>
									@endforeach
								</div>
							@else
								<p class="no-comments">No comments yet. Be the first to comment!</p>
							@endif

							<!-- Comment Form -->
							<div class="comment-form">
								<h4>Leave a Comment</h4>

								@if(session('success'))
									<div class="alert alert-success">
										{{ session('success') }}
									</div>
								@endif

								<form action="{{ route('blog.comment.store', $blog->slug) }}" method="POST">
									@csrf
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<input type="text" name="name" placeholder="Your Name *" value="{{ old('name') }}" required>
											@error('name')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 form-group">
											<input type="email" name="email" placeholder="Your Email *" value="{{ old('email') }}" required>
											@error('email')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 form-group">
											<textarea name="comment" placeholder="Your Comment *" rows="5" required>{{ old('comment') }}</textarea>
											@error('comment')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 form-group">
											<button type="submit" class="theme-btn btn-style-one">
												<span class="btn-wrap">
													<span class="text-one">Submit Comment</span>
													<span class="text-two">Submit Comment</span>
												</span>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Sidebar Column -->
				<div class="col-lg-4 col-md-12 col-sm-12">
					<aside class="sidebar">
						<!-- Search Widget -->
						<div class="sidebar-widget search-widget">
							<form action="{{ route('blog.index') }}" method="GET">
								<div class="form-group">
									<input type="search" name="search" placeholder="Search blog posts..." value="{{ request('search') }}">
									<button type="submit"><i class="fa fa-search"></i></button>
								</div>
							</form>
						</div>

						<!-- Categories Widget -->
						@if(isset($blog->category))
							<div class="sidebar-widget categories-widget">
								<h4>Categories</h4>
								<ul class="category-list">
									<li>
										<a href="{{ route('blog.category', $blog->category->slug) }}">
											{{ $blog->category->name }}
											<span>({{ $blog->category->getPublishedBlogsCount() }})</span>
										</a>
									</li>
								</ul>
							</div>
						@endif

						<!-- Popular Posts Widget -->
						@if($relatedPosts && $relatedPosts->count() > 0)
							<div class="sidebar-widget popular-posts-widget">
								<h4>Popular Posts</h4>
								<div class="popular-posts">
									@foreach($relatedPosts->take(3) as $popularPost)
										<div class="popular-post-item">
											@if($popularPost->featured_image)
												<div class="popular-post-image">
													<a href="{{ route('blog.details', $popularPost->slug) }}">
														<img src="{{ asset('storage/' . $popularPost->featured_image) }}" alt="{{ $popularPost->title }}" />
													</a>
												</div>
											@endif
											<div class="popular-post-content">
												<h5><a href="{{ route('blog.details', $popularPost->slug) }}">{{ $popularPost->title }}</a></h5>
												<span class="post-date"><i class="fa fa-calendar"></i> {{ $popularPost->getPublishedDate() }}</span>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endif

						<!-- Tags Widget -->
						@if($blog->tags && $blog->tags->count() > 0)
							<div class="sidebar-widget tags-widget">
								<h4>Tags</h4>
								<div class="tags-cloud">
									@foreach($blog->tags as $tag)
										<a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>
									@endforeach
								</div>
							</div>
						@endif
					</aside>
				</div>
			</div>
		</div>
	</section>
	<!-- End Blog Detail Section -->

@endsection

@push('scripts')
<style>
/* Blog Detail Styles */
.blog-detail {
	margin-bottom: 50px;
}

.blog-detail_image {
	margin-bottom: 30px;
	border-radius: 8px;
	overflow: hidden;
}

.blog-detail_image img {
	width: 100%;
	height: auto;
	display: block;
}

.blog-detail_meta {
	margin-bottom: 25px;
	padding-bottom: 20px;
	border-bottom: 1px solid #eee;
}

.blog-detail_meta-list {
	list-style: none;
	padding: 0;
	margin: 0;
	display: flex;
	flex-wrap: wrap;
	gap: 20px;
}

.blog-detail_meta-list li {
	color: #666;
	font-size: 14px;
}

.blog-detail_meta-list li i {
	margin-right: 5px;
	color: #f39c12;
}

.blog-detail_meta-list li a {
	color: #666;
	transition: color 0.3s;
}

.blog-detail_meta-list li a:hover {
	color: #f39c12;
}

.blog-detail_content {
	margin-bottom: 30px;
	line-height: 1.8;
	font-size: 16px;
}

.blog-detail_tags {
	margin-bottom: 30px;
	padding: 20px 0;
	border-top: 1px solid #eee;
	border-bottom: 1px solid #eee;
}

.tag-badge {
	display: inline-block;
	padding: 5px 15px;
	margin: 5px 5px 5px 0;
	background: #f8f9fa;
	border-radius: 20px;
	color: #333;
	font-size: 14px;
	transition: all 0.3s;
}

.tag-badge:hover {
	background: #f39c12;
	color: #fff;
}

.blog-detail_author {
	margin-bottom: 40px;
	padding: 25px;
	background: #f8f9fa;
	border-radius: 8px;
}

.author-inner {
	display: flex;
	gap: 20px;
}

.author-image {
	flex-shrink: 0;
}

.author-image img {
	width: 80px;
	height: 80px;
	border-radius: 50%;
	object-fit: cover;
}

.author-placeholder {
	width: 80px;
	height: 80px;
	border-radius: 50%;
	background: #f39c12;
	color: #fff;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 32px;
	font-weight: bold;
}

.author-content h4 {
	margin-bottom: 10px;
	font-size: 18px;
}

.author-content p {
	margin: 0;
	color: #666;
	font-size: 14px;
}

.blog-detail_navigation {
	margin-bottom: 50px;
	padding: 30px 0;
	border-top: 1px solid #eee;
	border-bottom: 1px solid #eee;
}

.nav-item {
	padding: 15px;
	background: #f8f9fa;
	border-radius: 8px;
	transition: all 0.3s;
}

.nav-item:hover {
	background: #f39c12;
}

.nav-item:hover a {
	color: #fff;
}

.nav-item a {
	display: block;
	color: #333;
	text-decoration: none;
}

.nav-label {
	display: block;
	font-size: 12px;
	text-transform: uppercase;
	margin-bottom: 5px;
	color: #999;
}

.nav-title {
	display: block;
	font-weight: 600;
}

.nav-item.next-post {
	text-align: right;
}

.blog-detail_related {
	margin-bottom: 50px;
}

.blog-detail_related h3 {
	margin-bottom: 30px;
}

.related-post-item {
	margin-bottom: 20px;
	border-radius: 8px;
	overflow: hidden;
	background: #f8f9fa;
}

.related-post-image img {
	width: 100%;
	height: 200px;
	object-fit: cover;
}

.related-post-content {
	padding: 20px;
}

.related-post-content h4 {
	margin-bottom: 10px;
	font-size: 16px;
}

.related-post-content h4 a {
	color: #333;
	transition: color 0.3s;
}

.related-post-content h4 a:hover {
	color: #f39c12;
}

.related-post-meta {
	display: flex;
	gap: 15px;
	font-size: 12px;
	color: #999;
}

.blog-detail_comments {
	margin-top: 50px;
}

.blog-detail_comments h3 {
	margin-bottom: 30px;
}

.comments-list {
	margin-bottom: 40px;
}

.comment-item {
	display: flex;
	gap: 20px;
	margin-bottom: 30px;
	padding-bottom: 30px;
	border-bottom: 1px solid #eee;
}

.comment-avatar {
	flex-shrink: 0;
}

.avatar-placeholder {
	width: 50px;
	height: 50px;
	border-radius: 50%;
	background: #f39c12;
	color: #fff;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 20px;
	font-weight: bold;
}

.comment-content h5 {
	margin-bottom: 5px;
	font-size: 16px;
}

.comment-meta {
	margin-bottom: 10px;
	font-size: 12px;
	color: #999;
}

.comment-content p {
	margin: 0;
	color: #666;
}

.no-comments {
	padding: 30px;
	background: #f8f9fa;
	text-align: center;
	color: #999;
	border-radius: 8px;
	margin-bottom: 30px;
}

.comment-form {
	padding: 30px;
	background: #f8f9fa;
	border-radius: 8px;
}

.comment-form h4 {
	margin-bottom: 20px;
}

.alert-success {
	padding: 15px;
	background: #d4edda;
	border: 1px solid #c3e6cb;
	color: #155724;
	border-radius: 5px;
	margin-bottom: 20px;
}

.text-danger {
	color: #dc3545;
	font-size: 12px;
	margin-top: 5px;
	display: block;
}

/* Sidebar Styles */
.sidebar {
	padding-left: 30px;
}

.sidebar-widget {
	margin-bottom: 40px;
}

.sidebar-widget h4 {
	margin-bottom: 20px;
	font-size: 18px;
	font-weight: 600;
}

.search-widget .form-group {
	position: relative;
}

.search-widget input {
	width: 100%;
	padding: 12px 45px 12px 15px;
	border: 1px solid #ddd;
	border-radius: 5px;
}

.search-widget button {
	position: absolute;
	right: 0;
	top: 0;
	height: 100%;
	width: 45px;
	background: #f39c12;
	border: none;
	color: #fff;
	border-radius: 0 5px 5px 0;
	cursor: pointer;
}

.category-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.category-list li {
	border-bottom: 1px solid #eee;
}

.category-list li:last-child {
	border-bottom: none;
}

.category-list a {
	display: flex;
	justify-content: space-between;
	padding: 10px 0;
	color: #333;
	transition: color 0.3s;
}

.category-list a:hover {
	color: #f39c12;
}

.popular-post-item {
	display: flex;
	gap: 15px;
	margin-bottom: 20px;
}

.popular-post-image {
	flex-shrink: 0;
}

.popular-post-image img {
	width: 80px;
	height: 80px;
	border-radius: 5px;
	object-fit: cover;
}

.popular-post-content h5 {
	margin-bottom: 5px;
	font-size: 14px;
}

.popular-post-content h5 a {
	color: #333;
	transition: color 0.3s;
}

.popular-post-content h5 a:hover {
	color: #f39c12;
}

.post-date {
	font-size: 12px;
	color: #999;
}

.tags-cloud {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.tags-cloud a {
	display: inline-block;
	padding: 5px 15px;
	background: #f8f9fa;
	border-radius: 20px;
	color: #333;
	font-size: 14px;
	transition: all 0.3s;
}

.tags-cloud a:hover {
	background: #f39c12;
	color: #fff;
}

@media (max-width: 991px) {
	.sidebar {
		padding-left: 0;
		margin-top: 50px;
	}

	.blog-detail_navigation .col-lg-6:first-child {
		margin-bottom: 15px;
	}

	.nav-item.next-post {
		text-align: left;
	}
}
</style>
@endpush
