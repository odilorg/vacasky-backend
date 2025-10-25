@extends('layouts.app')

{{-- SEO Meta Tags --}}
@section('title')
Blog | Vacasky Travel
@endsection

@section('meta_description')
Read our latest travel tips, destination guides, and travel stories. Get inspired for your next adventure with Vacasky.
@endsection

@section('meta_keywords')
travel blog, vacation tips, travel guides, destination guides
@endsection

@section('content')

	<!-- Page Banner -->
	<section class="page-banner" style="background-image: url({{ asset('vacasky/images/background/15.jpg') }})">
		<div class="auto-container">
			<ul class="page-breadbrumbs">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li>Blog</li>
			</ul>
			<h1 class="page-banner_title">TRAVEL BLOG</h1>
		</div>
	</section>
	<!-- End Page Banner -->

	<!-- Blog Grid Section -->
	<section class="blog-grid-section">
		<div class="auto-container">
			<div class="row clearfix">
				@forelse($blogs as $blog)
					<!-- Blog Block -->
					<div class="col-lg-4 col-md-6 col-sm-12 blog-block">
						<div class="blog-block-one">
							<div class="inner-box">
								@if($blog->featured_image)
									<div class="image-box">
										<a href="{{ route('blog.details', $blog->slug) }}">
											<img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" />
										</a>
									</div>
								@endif
								<div class="lower-content">
									<!-- Blog Meta -->
									<ul class="post-meta">
										<li><i class="fa fa-calendar"></i> {{ $blog->getPublishedDate() }}</li>
										@if($blog->category)
											<li>
												<i class="fa fa-folder"></i>
												<a href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a>
											</li>
										@endif
										<li><i class="fa fa-clock"></i> {{ $blog->reading_time }} min read</li>
									</ul>

									<!-- Blog Title -->
									<h3>
										<a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
									</h3>

									<!-- Blog Excerpt -->
									<div class="text">
										{{ $blog->excerpt }}
									</div>

									<!-- Read More Link -->
									<div class="link-box">
										<a href="{{ route('blog.details', $blog->slug) }}" class="theme-btn btn-style-one">
											<span class="btn-wrap">
												<span class="text-one">Read More</span>
												<span class="text-two">Read More</span>
											</span>
										</a>
									</div>

									<!-- Tags -->
									@if($blog->tags && $blog->tags->count() > 0)
										<div class="blog-tags">
											@foreach($blog->tags->take(3) as $tag)
												<a href="{{ route('blog.tag', $tag->slug) }}" class="tag-badge">{{ $tag->name }}</a>
											@endforeach
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				@empty
					<div class="col-12">
						<div class="no-blogs">
							<h3>No blog posts found</h3>
							<p>Check back soon for new travel stories and tips!</p>
						</div>
					</div>
				@endforelse
			</div>

			<!-- Pagination -->
			@if($blogs->hasPages())
				<div class="pagination-wrapper">
					{{ $blogs->links() }}
				</div>
			@endif
		</div>
	</section>
	<!-- End Blog Grid Section -->

@endsection

@push('scripts')
<style>
/* Blog Grid Styles */
.blog-grid-section {
	padding: 80px 0;
}

.blog-block {
	margin-bottom: 40px;
}

.blog-block-one .inner-box {
	background: #fff;
	border-radius: 8px;
	overflow: hidden;
	box-shadow: 0 5px 15px rgba(0,0,0,0.1);
	transition: all 0.3s;
}

.blog-block-one .inner-box:hover {
	box-shadow: 0 10px 30px rgba(0,0,0,0.15);
	transform: translateY(-5px);
}

.blog-block-one .image-box {
	position: relative;
	overflow: hidden;
}

.blog-block-one .image-box img {
	width: 100%;
	height: 250px;
	object-fit: cover;
	transition: transform 0.3s;
}

.blog-block-one .inner-box:hover .image-box img {
	transform: scale(1.1);
}

.blog-block-one .lower-content {
	padding: 25px;
}

.post-meta {
	list-style: none;
	padding: 0;
	margin: 0 0 15px 0;
	display: flex;
	flex-wrap: wrap;
	gap: 15px;
}

.post-meta li {
	color: #999;
	font-size: 13px;
}

.post-meta li i {
	margin-right: 5px;
	color: #f39c12;
}

.post-meta li a {
	color: #999;
	transition: color 0.3s;
}

.post-meta li a:hover {
	color: #f39c12;
}

.blog-block-one h3 {
	margin-bottom: 15px;
	font-size: 20px;
	line-height: 1.4;
}

.blog-block-one h3 a {
	color: #333;
	transition: color 0.3s;
}

.blog-block-one h3 a:hover {
	color: #f39c12;
}

.blog-block-one .text {
	margin-bottom: 20px;
	color: #666;
	font-size: 14px;
	line-height: 1.6;
}

.blog-tags {
	margin-top: 15px;
	padding-top: 15px;
	border-top: 1px solid #eee;
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.tag-badge {
	display: inline-block;
	padding: 4px 12px;
	background: #f8f9fa;
	border-radius: 15px;
	color: #666;
	font-size: 12px;
	transition: all 0.3s;
}

.tag-badge:hover {
	background: #f39c12;
	color: #fff;
}

.no-blogs {
	text-align: center;
	padding: 60px 20px;
	background: #f8f9fa;
	border-radius: 8px;
}

.no-blogs h3 {
	margin-bottom: 10px;
	color: #333;
}

.no-blogs p {
	color: #666;
	margin: 0;
}

/* Pagination */
.pagination-wrapper {
	margin-top: 40px;
	text-align: center;
}

.pagination-wrapper nav {
	display: inline-block;
}

@media (max-width: 767px) {
	.blog-grid-section {
		padding: 50px 0;
	}

	.blog-block {
		margin-bottom: 30px;
	}
}
</style>
@endpush
