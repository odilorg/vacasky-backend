@extends('layouts.app')

{{-- SEO Meta Tags --}}
@section('title', 'Explore All Tours & Travel Packages | Vacasky')

@section('meta_description')
Browse our complete collection of amazing tours and travel packages. Find your perfect adventure with destinations worldwide, competitive prices, and unforgettable experiences.
@endsection

@section('meta_keywords')
tours, travel packages, vacation packages, tour packages, travel deals, adventure tours, cultural tours, sightseeing tours
@endsection

@section('canonical_url')
{{ route('tours.index') }}
@endsection

{{-- Open Graph --}}
@section('og_type', 'website')
@section('og_title', 'Explore All Tours & Travel Packages | Vacasky')
@section('og_description', 'Browse our complete collection of amazing tours and travel packages worldwide.')
@section('og_image', asset('vacasky/images/logo.png'))
@section('og_url', route('tours.index'))

{{-- Schema.org JSON-LD for Tour Listing --}}
@push('styles')
<script type="application/ld+json">
@php
$itemListElements = [];
foreach ($tours as $index => $tour) {
    $itemListElements[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'item' => [
            '@type' => 'TouristTrip',
            'name' => $tour->name,
            'url' => route('tours.details', $tour->slug),
            'image' => $tour->featured_image ? asset('storage/' . $tour->featured_image) : asset('vacasky/images/resource/tour-default.jpg'),
            'description' => strip_tags($tour->overview),
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'USD',
                'price' => number_format($tour->price, 2, '.', '')
            ]
        ]
    ];
}

$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'itemListElement' => $itemListElements,
    'numberOfItems' => $tours->total()
];

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
				<li>Tours</li>
			</ul>
			<h1 class="page-banner_title">EXPLORE OUR TOURS</h1>
		</div>
	</section>
	<!-- End Page Banner -->

	<!-- Tours Grid Section -->
	<section class="tours-grid-section">
		<div class="auto-container">

			<!-- Section Title -->
			<div class="sec-title centered">
				<div class="sec-title_title">Discover Amazing Destinations</div>
				<h2 class="sec-title_heading">Choose Your Next <span>Adventure</span></h2>
			</div>

			@if($tours->count() > 0)
				<!-- Tours Grid -->
				<div class="row clearfix">
					@foreach($tours as $index => $tour)
						<!-- Tour Card -->
						<div class="tour-card-col col-lg-4 col-md-6 col-sm-12">
							<div class="tour-card">
								<div class="tour-card_image">
									<a href="{{ route('tours.details', $tour->slug) }}">
										@if($tour->featured_image)
											<img src="{{ asset('storage/' . $tour->featured_image) }}" alt="{{ $tour->name }}" />
										@else
											<img src="{{ asset('vacasky/images/resource/tour-default.jpg') }}" alt="{{ $tour->name }}" />
										@endif
									</a>

									<!-- Featured Badge -->
									@if($tour->is_featured)
										<div class="tour-card_badge">
											<span class="badge-featured">Featured</span>
										</div>
									@endif

									<!-- Price Badge -->
									<div class="tour-card_price">
										<span class="price-amount">${{ number_format($tour->price, 0) }}</span>
										<span class="price-label">per person</span>
									</div>
								</div>

								<div class="tour-card_content">
									<!-- Tour Meta -->
									<div class="tour-card_meta">
										<div class="tour-meta-item">
											<span class="icon fa fa-map-marker-alt"></span>
											<span class="text">{{ $tour->location }}</span>
										</div>
										<div class="tour-meta-item">
											<span class="icon fa fa-clock"></span>
											<span class="text">{{ $tour->duration }}</span>
										</div>
										@if($tour->rating > 0)
											<div class="tour-meta-item">
												<span class="icon fa fa-star"></span>
												<span class="text">{{ $tour->rating }}/5</span>
											</div>
										@endif
									</div>

									<!-- Tour Title -->
									<h3 class="tour-card_title">
										<a href="{{ route('tours.details', $tour->slug) }}">{{ $tour->name }}</a>
									</h3>

									<!-- Tour Description -->
									<div class="tour-card_text">
										{{ Str::limit(strip_tags($tour->overview), 120) }}
									</div>

									<!-- Tour Footer -->
									<div class="tour-card_footer">
										<div class="tour-card_info">
											<span class="icon fa fa-users"></span>
											<span class="text">Max {{ $tour->max_people }} people</span>
										</div>
										<a href="{{ route('tours.details', $tour->slug) }}" class="tour-card_link">
											View Details <span class="icon fa fa-arrow-right"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<!-- Pagination -->
				@if($tours->hasPages())
					<div class="pagination-wrapper">
						{{ $tours->links('vendor.pagination.vacasky') }}
					</div>
				@endif

			@else
				<!-- Empty State -->
				<div class="empty-state">
					<div class="empty-state_icon">
						<span class="icon fa fa-map-marked-alt"></span>
					</div>
					<h3 class="empty-state_title">No Tours Available</h3>
					<div class="empty-state_text">
						We're currently updating our tour packages. Please check back soon for exciting new destinations!
					</div>
					<a href="{{ route('home') }}" class="theme-btn btn-style-one">
						<span class="btn-wrap">
							<span class="text-one">Back to Home</span>
							<span class="text-two">Back to Home</span>
						</span>
					</a>
				</div>
			@endif

		</div>
	</section>
	<!-- End Tours Grid Section -->

	<!-- Add Custom Styles -->
	@push('styles')
	<style>
		.tours-grid-section {
			position: relative;
			padding: 100px 0px 70px;
		}

		.tour-card-col {
			margin-bottom: 30px;
		}

		.tour-card {
			position: relative;
			background-color: #ffffff;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0px 0px 30px rgba(0,0,0,0.10);
			transition: all 0.3s ease;
		}

		.tour-card:hover {
			box-shadow: 0px 0px 40px rgba(0,0,0,0.15);
			transform: translateY(-5px);
		}

		.tour-card_image {
			position: relative;
			overflow: hidden;
			height: 280px;
		}

		.tour-card_image img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: all 0.5s ease;
		}

		.tour-card:hover .tour-card_image img {
			transform: scale(1.1);
		}

		.tour-card_badge {
			position: absolute;
			top: 20px;
			left: 20px;
			z-index: 1;
		}

		.badge-featured {
			background-color: #ff5a5f;
			color: #ffffff;
			padding: 5px 15px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			text-transform: uppercase;
		}

		.tour-card_price {
			position: absolute;
			bottom: 20px;
			right: 20px;
			background-color: rgba(255,255,255,0.95);
			padding: 10px 20px;
			border-radius: 5px;
			text-align: center;
			z-index: 1;
		}

		.price-amount {
			display: block;
			font-size: 24px;
			font-weight: 700;
			color: #ff5a5f;
			line-height: 1.2;
		}

		.price-label {
			display: block;
			font-size: 12px;
			color: #666666;
		}

		.tour-card_content {
			padding: 25px;
		}

		.tour-card_meta {
			display: flex;
			flex-wrap: wrap;
			gap: 15px;
			margin-bottom: 15px;
			padding-bottom: 15px;
			border-bottom: 1px solid #eeeeee;
		}

		.tour-meta-item {
			display: flex;
			align-items: center;
			gap: 5px;
			font-size: 14px;
			color: #666666;
		}

		.tour-meta-item .icon {
			color: #ff5a5f;
		}

		.tour-card_title {
			font-size: 20px;
			font-weight: 700;
			line-height: 1.3;
			margin-bottom: 15px;
		}

		.tour-card_title a {
			color: #222222;
			transition: all 0.3s ease;
		}

		.tour-card_title a:hover {
			color: #ff5a5f;
		}

		.tour-card_text {
			font-size: 15px;
			line-height: 1.6;
			color: #666666;
			margin-bottom: 20px;
		}

		.tour-card_footer {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding-top: 20px;
			border-top: 1px solid #eeeeee;
		}

		.tour-card_info {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 14px;
			color: #666666;
		}

		.tour-card_info .icon {
			color: #ff5a5f;
		}

		.tour-card_link {
			font-size: 14px;
			font-weight: 600;
			color: #ff5a5f;
			transition: all 0.3s ease;
		}

		.tour-card_link:hover {
			color: #222222;
		}

		.tour-card_link .icon {
			margin-left: 5px;
			transition: all 0.3s ease;
		}

		.tour-card_link:hover .icon {
			margin-left: 10px;
		}

		/* Pagination */
		.pagination-wrapper {
			margin-top: 50px;
			text-align: center;
		}

		.pagination-outer {
			display: inline-block;
		}

		.pagination {
			display: flex;
			list-style: none;
			padding: 0;
			margin: 0;
			gap: 10px;
		}

		.pagination .page-item {
			display: inline-block;
		}

		.pagination .page-link {
			display: flex;
			align-items: center;
			justify-content: center;
			min-width: 45px;
			height: 45px;
			padding: 0 15px;
			font-size: 16px;
			font-weight: 600;
			color: #222222;
			background-color: #ffffff;
			border: 2px solid #eeeeee;
			border-radius: 5px;
			transition: all 0.3s ease;
			text-decoration: none;
			cursor: pointer;
		}

		.pagination .page-link:hover {
			color: #ffffff;
			background-color: #ff5a5f;
			border-color: #ff5a5f;
		}

		.pagination .page-item.active .page-link {
			color: #ffffff;
			background-color: #ff5a5f;
			border-color: #ff5a5f;
			pointer-events: none;
		}

		.pagination .page-item.disabled .page-link {
			color: #cccccc;
			background-color: #f8f8f8;
			border-color: #eeeeee;
			cursor: not-allowed;
			pointer-events: none;
		}

		.pagination .page-link .fa {
			font-size: 18px;
		}

		/* Empty State */
		.empty-state {
			text-align: center;
			padding: 80px 20px;
		}

		.empty-state_icon {
			font-size: 80px;
			color: #dddddd;
			margin-bottom: 30px;
		}

		.empty-state_title {
			font-size: 28px;
			font-weight: 700;
			color: #222222;
			margin-bottom: 15px;
		}

		.empty-state_text {
			font-size: 16px;
			color: #666666;
			margin-bottom: 30px;
			max-width: 600px;
			margin-left: auto;
			margin-right: auto;
		}

		/* Responsive */
		@media only screen and (max-width: 1023px) {
			.tour-card_image {
				height: 250px;
			}
		}

		@media only screen and (max-width: 767px) {
			.tours-grid-section {
				padding: 60px 0px 30px;
			}

			.tour-card_image {
				height: 220px;
			}

			.tour-card_meta {
				gap: 10px;
			}

			.tour-meta-item {
				font-size: 13px;
			}

			.tour-card_title {
				font-size: 18px;
			}

			.tour-card_footer {
				flex-direction: column;
				gap: 15px;
				align-items: flex-start;
			}
		}
	</style>
	@endpush

@endsection
