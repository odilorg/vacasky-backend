@extends('layouts.app')

{{-- SEO Meta Tags --}}
@section('title')
{{ $tour->meta_title ?? $tour->name . ' | Vacasky Tours' }}
@endsection

@section('meta_description')
{{ $tour->meta_description ?? strip_tags($tour->overview) }}
@endsection

@section('meta_keywords')
{{ $tour->meta_keywords ?? 'travel, tours, vacation' }}
@endsection

@section('canonical_url')
{{ route('tours.details', $tour->slug) }}
@endsection

{{-- Open Graph / Facebook --}}
@section('og_type')
product
@endsection

@section('og_title')
{{ $tour->meta_title ?? $tour->name }}
@endsection

@section('og_description')
{{ $tour->meta_description ?? strip_tags($tour->overview) }}
@endsection

@section('og_image')
{{ $tour->og_image ? asset('storage/' . $tour->og_image) : ($tour->featured_image ? asset('storage/' . $tour->featured_image) : asset('vacasky/images/logo.png')) }}
@endsection

@section('og_url')
{{ route('tours.details', $tour->slug) }}
@endsection

{{-- Twitter Card --}}
@section('twitter_title')
{{ $tour->meta_title ?? $tour->name }}
@endsection

@section('twitter_description')
{{ $tour->meta_description ?? strip_tags($tour->overview) }}
@endsection

@section('twitter_image')
{{ $tour->og_image ? asset('storage/' . $tour->og_image) : ($tour->featured_image ? asset('storage/' . $tour->featured_image) : asset('vacasky/images/logo.png')) }}
@endsection

@section('twitter_url')
{{ route('tours.details', $tour->slug) }}
@endsection

{{-- Geo Tags --}}
@section('geo_region')
{{ $tour->geo_region ?? '' }}
@endsection

@section('geo_placename')
{{ $tour->location }}
@endsection

@section('geo_position')
{{ $tour->latitude && $tour->longitude ? $tour->latitude . ';' . $tour->longitude : '' }}
@endsection

{{-- Schema.org JSON-LD for Tours --}}
@push('styles')
<script type="application/ld+json">
@php
$itineraryElements = [];
if ($tour->itinerary) {
    foreach ($tour->itinerary as $index => $day) {
        $itineraryElements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $day['title'] ?? 'Day ' . ($index + 1)
        ];
    }
}

$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'TouristTrip',
    'name' => $tour->name,
    'description' => strip_tags($tour->overview),
    'image' => $tour->featured_image ? asset('storage/' . $tour->featured_image) : asset('vacasky/images/logo.png'),
    'offers' => [
        '@type' => 'Offer',
        'url' => route('tours.details', $tour->slug),
        'priceCurrency' => 'USD',
        'price' => number_format($tour->price, 2, '.', ''),
        'availability' => 'https://schema.org/InStock'
    ],
    'provider' => [
        '@type' => 'TravelAgency',
        'name' => 'Vacasky',
        'url' => route('home')
    ],
    'duration' => $tour->duration,
    'location' => [
        '@type' => 'Place',
        'name' => $tour->location,
    ]
];

if (!empty($itineraryElements)) {
    $jsonLd['itinerary'] = [
        '@type' => 'ItemList',
        'itemListElement' => $itineraryElements
    ];
}

if ($tour->latitude && $tour->longitude) {
    $jsonLd['location']['geo'] = [
        '@type' => 'GeoCoordinates',
        'latitude' => (string)$tour->latitude,
        'longitude' => (string)$tour->longitude
    ];
}

if ($tour->rating && $tour->review_count) {
    $jsonLd['aggregateRating'] = [
        '@type' => 'AggregateRating',
        'ratingValue' => (string)$tour->rating,
        'reviewCount' => (string)$tour->review_count
    ];
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
				<li><a href="{{ route('tours.index') }}">tours</a></li>
				<li>{{ $tour->destination ?? $tour->location }}</li>
			</ul>
			<h1 class="page-banner_title">{{ strtoupper($tour->name) }}</h1>
		</div>
	</section>
	<!-- End Page Banner -->

	<!-- Gallery Seven -->
	<section class="gallery-seven">
		<div class="outer-container">
			@php
				$galleryImages = [];
				if ($tour->gallery && count($tour->gallery) > 0) {
					$galleryImages = $tour->gallery;
				} elseif ($tour->featured_image) {
					// If only featured image, show it 3 times for carousel effect
					$galleryImages = array_fill(0, 3, $tour->featured_image);
				} else {
					// Default images
					$galleryImages = array_fill(0, 3, 'vacasky/images/resource/tour-default.jpg');
				}
			@endphp

			<div class="gallery-carousel-three owl-carousel owl-theme">
				@foreach($galleryImages as $image)
					<!-- Image -->
					<div class="image">
						<a class="lightbox-image" href="{{ Str::startsWith($image, 'vacasky/') ? asset($image) : asset('storage/' . $image) }}">
							<img src="{{ Str::startsWith($image, 'vacasky/') ? asset($image) : asset('storage/' . $image) }}" alt="{{ $tour->name }}" />
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</section>
	<!-- End Gallery Seven  -->

	<!-- Tour Detail Two -->
	<section class="tour-detail-two">
		<div class="auto-container">
			<div class="row clearfix">
				<div class="col-lg-8 col-md-12 col-sm-12">
					<h3>overview</h3>
					<div>{!! $tour->overview !!}</div>
					<div class="info_outer">
						<div class="row clearfix">
							<!-- Column -->
							<div class="column col-lg-6 col-md-6 col-sm-12">
								<ul class="tour-detail-two_list">
									<li><span class="icon fas fa-map-marker-alt fa-fw"></span>{{ $tour->location }}</li>
									<li><span class="icon fas fa-dollar-sign fa-fw"></span>Start from ${{ number_format($tour->price, 2) }}</li>
								</ul>
							</div>
							<!-- Column -->
							<div class="column col-lg-6 col-md-6 col-sm-12">
								<ul class="tour-detail-two_list">
									<li><span class="icon fas fa-clock fa-fw"></span>{{ $tour->duration }}</li>
									<li><span class="icon fas fa-users fa-fw"></span>{{ $tour->max_people }} People</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="options_outer">
						<div class="row clearfix">
							<!-- Column -->
							<div class="column col-lg-6 col-md-6 col-sm-12">
								<h4>INCLUDED</h4>
								<ul class="tour-detail-two_options">
									@if($tour->inclusions && count($tour->inclusions) > 0)
										@foreach($tour->inclusions as $inclusion)
											<li>{{ $inclusion['item'] ?? $inclusion }}</li>
										@endforeach
									@else
										<li>Details to be announced</li>
									@endif
								</ul>
							</div>
							<!-- Column -->
							<div class="column col-lg-6 col-md-6 col-sm-12">
								<h4>NOT INCLUDED</h4>
								<ul class="tour-detail-two_options cross">
									@if($tour->exclusions && count($tour->exclusions) > 0)
										@foreach($tour->exclusions as $exclusion)
											<li>{{ $exclusion['item'] ?? $exclusion }}</li>
										@endforeach
									@else
										<li>Details to be announced</li>
									@endif
								</ul>
							</div>
						</div>
					</div>
					<h4>ITINERARY</h4>

					<!-- Accordion Box / Style Two -->
					<ul class="accordion-box style-two">

						@if($tour->itinerary && count($tour->itinerary) > 0)
							@foreach($tour->itinerary as $index => $day)
								<!-- Block -->
								<li class="accordion block {{ $index === 0 ? 'active-block' : '' }}">
									<div class="acc-btn {{ $index === 0 ? 'active' : '' }}">
										<div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>
										<span class="accordion_number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
										{{ $day['title'] ?? 'Day ' . ($index + 1) }}
									</div>
									<div class="acc-content {{ $index === 0 ? 'current' : '' }}">
										<div class="content">
											@if(isset($day['image']) && $day['image'])
												<div class="image">
													<img src="{{ asset('storage/' . $day['image']) }}" alt="{{ $day['title'] ?? 'Day ' . ($index + 1) }}" />
												</div>
											@endif

											<!-- Accordian Info Tabs -->
											<div class="accordian-info-tabs">
												<!-- Accordian Tabs -->
												<div class="accordian-tabs tabs-box">

													<!-- Tab Btns -->
													<ul class="tab-btns tab-buttons clearfix">
														@if(isset($day['overview']) && $day['overview'])
															<li data-tab="#day-{{ $index }}-overview" class="tab-btn active-btn">Overview</li>
														@endif
														@if(isset($day['schedule']) && $day['schedule'])
															<li data-tab="#day-{{ $index }}-schedule" class="tab-btn">Schedule</li>
														@endif
														@if(isset($day['meals']) && $day['meals'])
															<li data-tab="#day-{{ $index }}-meals" class="tab-btn">Meals</li>
														@endif
														@if(isset($day['accommodation']) && $day['accommodation'])
															<li data-tab="#day-{{ $index }}-accommodation" class="tab-btn">Accommodation</li>
														@endif
													</ul>

													<!-- Tabs Container -->
													<div class="tabs-content">

														@if(isset($day['overview']) && $day['overview'])
															<!-- Tab / Active Tab -->
															<div class="tab active-tab" id="day-{{ $index }}-overview">
																<div class="accordian-description">{!! $day['overview'] !!}</div>
															</div>
														@endif

														@if(isset($day['schedule']) && $day['schedule'])
															<!-- Tab -->
															<div class="tab" id="day-{{ $index }}-schedule">
																<div class="accordian-description">{!! $day['schedule'] !!}</div>
															</div>
														@endif

														@if(isset($day['meals']) && $day['meals'])
															<!-- Tab -->
															<div class="tab" id="day-{{ $index }}-meals">
																<div class="accordian-description">{!! $day['meals'] !!}</div>
															</div>
														@endif

														@if(isset($day['accommodation']) && $day['accommodation'])
															<!-- Tab -->
															<div class="tab" id="day-{{ $index }}-accommodation">
																<div class="accordian-description">{!! $day['accommodation'] !!}</div>
															</div>
														@endif

													</div>
												</div>
											</div>

										</div>
									</div>
								</li>
							@endforeach
						@else
							<li class="accordion block active-block">
								<div class="acc-btn active">
									<div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>
									<span class="accordion_number">01</span> Itinerary Details
								</div>
								<div class="acc-content current">
									<div class="content">
										<p>Detailed itinerary will be provided soon. Please contact us for more information.</p>
									</div>
								</div>
							</li>
						@endif

					</ul>

					<!-- Comments Area -->
					<div class="comments-area">
						<div class="comments-area_pattern" style="background-image: url({{ asset('vacasky/images/icons/pattern-1.png') }})"></div>
						<div class="comments-area_pattern-two" style="background-image: url({{ asset('vacasky/images/icons/pattern-1.png') }})"></div>
						<div class="group-title">
							<h4>REVIEWS</h4>
						</div>

						<div class="comment-box">

							<!-- Comment -->
							<div class="comment">
								<div class="text">"This article is fantastic! As someone who loves exploring the outdoors, I'm always on the lookout for new national parks to add to my bucket list. Thanks for the inspiration!"</div>
								<div class="news-block_four-author">
									<div class="news-block_four-author_image">
										<img src="{{ asset('vacasky/images/resource/author-8.jpg') }}" alt="" />
									</div>
									Jessica Laurens
									<span>December 3, 2025</span>
								</div>
							</div>

							<!-- Comment -->
							<div class="comment">
								<div class="text">"I've been lucky enough to visit a few of the national parks on this list, and I can vouch for their incredible beauty and unique experiences. I highly recommend visiting Yellowstone and Banff - they are truly unforgettable destinations!"</div>
								<div class="news-block_four-author">
									<div class="news-block_four-author_image">
										<img src="{{ asset('vacasky/images/resource/author-7.jpg') }}" alt="" />
									</div>
									Jack Smith
									<span>November 10, 2025</span>
								</div>
							</div>

						</div>
					</div>

				</div>

				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="tour_plans position-sticky">
						<div class="title-box">
							<h4>JOIN THIS TOUR</h4>
							<div class="text">No extra hassle, just fill the form and let us contact you for more informations.</div>
						</div>

						<!-- Booking Form -->
						<div class="booking-form">
							<form method="post" action="{{ route('tours.booking', $tour->slug) }}">
								@csrf
								<!-- Form Group -->
								<div class="form-group">
									<label>first name*</label>
									<select name="title" class="custom-select-box">
										<option>Mrs</option>
										<option>Mr</option>
									</select>
								</div>
								<!-- Form Group -->
								<div class="form-group">
									<label>Starting Date*</label>
									<input class="datepicker" type="text" name="start_date" placeholder="March 23, 2023" required="">
								</div>
								<!-- Form Group -->
								<div class="form-group">
									<label>Guests*</label>
									<select name="guests" class="custom-select-box">
										<option>02 Adults, 01 Kids</option>
										<option>03 Adults, 03 Kids</option>
										<option>04 Adults, 05 Kids</option>
										<option>05 Adults, 07 Kids</option>
										<option>06 Adults, 09 Kids</option>
										<option>07 Adults, 10 Kids</option>
									</select>
								</div>
								<!-- Form Group -->
								<div class="form-group">
									<label>Extra Facilities</label>
									<select name="extra_facility" class="custom-select-box">
										<option>Airport Pickup ($ 1,000)</option>
										<option>Airport Pickup ($ 2,000)</option>
										<option>Airport Pickup ($ 3,000)</option>
										<option>Airport Pickup ($ 4,000)</option>
										<option>Airport Pickup ($ 5,000)</option>
										<option>Airport Pickup ($ 6,000)</option>
									</select>
								</div>
								<div class="form-group">
									<div class="d-flex justify-content-between align-items-center">
										<div class="total-payment">
											Total Payment
											<span>$ {{ number_format($tour->price, 0) }}</span>
										</div>
										<button type="submit" class="btn-style-two theme-btn">
											<span class="btn-wrap">
												<span class="text-one">Book This Tour</span>
												<span class="text-two">Book This Tour</span>
											</span>
										</button>
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Tour Detail Two -->

@endsection
