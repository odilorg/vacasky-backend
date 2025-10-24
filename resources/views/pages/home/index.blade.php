@extends('layouts.app')

@section('title', 'Vacasky - Tour & Travel Agency | Homepage')

@section('content')

	<!-- Banner One -->
	<section class="banner-one">
		<div class="banner-one_image-layer" style="background-image: url({{ asset('vacasky/images/main-slider/1.jpg') }})"></div>
		<div class="auto-container">
			<!-- Content Column -->
			<div class="banner-one_content">
				<div class="banner-one_content-inner">
					<div class="banner-one_title">
						UNFORGETTABLE TRAVEL AWAITS THE
					</div>
					<h1 class="banner-one_heading">ADVENTURE</h1>
					<div class="banner-one_text">Experience the thrill of exploring the world's most fascinating destinations <br> with our expertly curated travel packages.</div>
					<!-- Form Box -->


					<!-- Clients Box -->
					<div class="clients-box">
						<!-- Sponsors Carousel -->
						<ul class="sponsors-carousel owl-carousel owl-theme">
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/1.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/2.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/3.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/4.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/5.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/1.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/2.png') }}" alt=""></a></figure></li>
							<li class="slide-item"><figure class="client-one_image-box"><a href="#"><img src="{{ asset('vacasky/images/clients/3.png') }}" alt=""></a></figure></li>
						</ul>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End Banner One -->

	<!-- Destination One -->
	<section class="destination-one">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<h2 class="sec-title_heading">POPULAR DESTINATIONS</h2>
				<div class="sec-title-text">Explore our top destinations right from our beloved clients' reviews.</div>
			</div>
			<div class="row clearfix">

				<!-- Destination Block One -->
				<div class="destination-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="destination-block_one-inner">
						<div class="destination-block_one-image">
							<a href="{{ route('destinations.details', 'italy') }}"><img src="{{ asset('vacasky/images/resource/destination-1.jpg') }}" alt="" /></a>
						</div>
						<div class="destination-block_one-content">
							<h3 class="destination-block_one-title"><a href="{{ route('destinations.details', 'italy') }}">Italy</a></h3>
							<div class="destination-block_one-location">20 Packages</div>
						</div>
					</div>
				</div>

				<!-- Destination Block One -->
				<div class="destination-block_one col-lg-6 col-md-12 col-sm-12">
					<div class="destination-block_one-inner">
						<div class="destination-block_one-image">
							<a href="{{ route('destinations.details', 'switzerland') }}"><img src="{{ asset('vacasky/images/resource/destination-2.jpg') }}" alt="" /></a>
							<div class="destination-block_one-overlay">
								<div class="destination-block_one-overlay-content">
									<h3 class="destination-block_one-title"><a href="{{ route('destinations.details', 'switzerland') }}">Italy</a></h3>
									<div class="destination-block_one-location">20 Packages</div>
									<div class="destination-block_one-text">Switzerland, officially the Swiss Confederation, is a landlocked country located at the northern part of Europe.</div>
									<div class="destination-block_one-btns">
										<a href="{{ route('destinations.details', 'switzerland') }}" class="theme-btn book-btn">Book Now</a>
										<a href="{{ route('destinations.details', 'switzerland') }}" class="theme-btn learn-btn">Learn More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Destination Block One -->
				<div class="destination-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="destination-block_one-inner">
						<div class="destination-block_one-image">
							<a href="{{ route('destinations.details', 'greece') }}"><img src="{{ asset('vacasky/images/resource/destination-3.jpg') }}" alt="" /></a>
						</div>
						<div class="destination-block_one-content">
							<h3 class="destination-block_one-title"><a href="{{ route('destinations.details', 'greece') }}">Greece</a></h3>
							<div class="destination-block_one-location">20 Packages</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Destination One -->

	<!-- Feature One -->
	<section class="feature-one" style="background-image: url({{ asset('vacasky/images/background/19.jpg') }})">
		<div class="auto-container">
			<div class="row clearfix">

				<!-- Feature Block One -->
				<div class="feature-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="feature-block_one-inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
						<div class="feature-block_one-icon flaticon-smile-1"></div>
						<h5 class="feature-block_one-title">Customer Delight</h5>
						<div class="feature-block_one-text">We deliver the best service and experience for our customer.</div>
					</div>
				</div>

				<!-- Feature Block One -->
				<div class="feature-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="feature-block_one-inner wow fadeInLeft" data-wow-delay="150ms" data-wow-duration="1500ms">
						<div class="feature-block_one-icon flaticon-mountain"></div>
						<h5 class="feature-block_one-title">Authentic Adventure</h5>
						<div class="feature-block_one-text">We deliver the real adventure experience for our dear customer.</div>
					</div>
				</div>

				<!-- Feature Block One -->
				<div class="feature-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="feature-block_one-inner wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms">
						<div class="feature-block_one-icon flaticon-flags"></div>
						<h5 class="feature-block_one-title">Expert Guides</h5>
						<div class="feature-block_one-text">We deliver only expert tour guides for our dear customer.</div>
					</div>
				</div>

				<!-- Feature Block One -->
				<div class="feature-block_one col-lg-3 col-md-6 col-sm-12">
					<div class="feature-block_one-inner wow fadeInLeft" data-wow-delay="450ms" data-wow-duration="1500ms">
						<div class="feature-block_one-icon flaticon-clock"></div>
						<h5 class="feature-block_one-title">Time Flexibility</h5>
						<div class="feature-block_one-text">We welcome time flexibility of traveling for our dear customer.</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Feature One -->

	<!-- Package One -->
	<section class="package-one">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title">
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<div class="title-content">
						<h2 class="sec-title_heading">SPECIAL PACKAGES</h2>
						<div class="sec-title-text">Get special travel packages made tailored for your needs.</div>
					</div>
					<a class="package-one_more" href="{{ route('tours.index') }}">See More Packages</a>
				</div>
			</div>
			<div class="row clearfix">

				<!-- Package Block One -->
				<div class="package-block_one col-lg-3 col-md-4 col-sm-12">
					<div class="package-block_one-inner">
						<div class="package-block_one-image">
							<img src="{{ asset('vacasky/images/resource/package-1.jpg') }}" alt="" />
							<div class="package-block_one-number">01</div>
							<div class="package-block_one-content">
								<h4 class="package-block_one-title"><a href="{{ route('tours.details', 'cultural-immersion-package') }}">Cultural Immersion Package</a></h4>
							</div>
						</div>
					</div>
				</div>

				<!-- Package Block Two -->
				<div class="package-block_two col-lg-9 col-md-8 col-sm-12">
					<div class="package-block_two-inner">
						<div class="package-block_two-image">
							<img src="{{ asset('vacasky/images/resource/package-2.jpg') }}" alt="" />
							<div class="package-block_two-number">02</div>
						</div>
						<div class="package-block_two-content">
							<div class="d-flex justify-content-between flex-wrap">
								<h1 class="package-block_two-title"><a href="{{ route('tours.details', 'escape-to-paradise') }}">ESCAPE <br> TO PARADISE</a></h1>
								<div class="package-block_two-box">
									<div class="package-block_two-text">Bask in the warm tropical sun with our exclusive Tropical Escape Package. This 7-day trip takes you to the most stunning tropical islands.</div>
									<!-- Button Box -->
									<div class="button-box">
										<a class="btn-style-two theme-btn" href="{{ route('tours.booking', 'escape-to-paradise') }}">
											<div class="btn-wrap">
												<span class="text-one">Book Now</span>
												<span class="text-two">Book Now</span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Package One -->

	<!-- Counter One -->
	<section class="counter-one">
		<div class="auto-container">
			<div class="inner-container">
				<div class="counter-image">
					<img src="{{ asset('vacasky/images/resource/counter.jpg') }}" alt="" />
					<div class="counter-one_content">
						<h2 class="counter-one_title">ONLY THE BEST QUALITY FOR YOU</h2>
						<div class="counter-one_text">You deserve the ultimate best quality for your memorable experiences.</div>
					</div>
					<div class="counter-one_lower-content">
						<div class="counter-text_two">Take a look at our numbers for our <br> credibility. Let's have an adventure!</div>
						<div class="row clearfix">

							<!-- Counter Column -->
							<div class="counter-one_block col-lg-3 col-md-6 col-sm-6">
								<div class="counter-one_block-inner wow flipInX" data-wow-delay="0ms" data-wow-duration="1500ms">
									<div class="counter-one_counter"><span class="odometer" data-count="20"></span>+</div>
									<div class="counter-one_counter-text">years of experience</div>
								</div>
							</div>

							<!-- Counter Column -->
							<div class="counter-one_block col-lg-3 col-md-6 col-sm-6">
								<div class="counter-one_block-inner wow flipInX" data-wow-delay="150ms" data-wow-duration="1500ms">
									<div class="counter-one_counter"><span class="odometer" data-count="100"></span>+</div>
									<div class="counter-one_counter-text">destination countries</div>
								</div>
							</div>

							<!-- Counter Column -->
							<div class="counter-one_block col-lg-3 col-md-6 col-sm-6">
								<div class="counter-one_block-inner wow flipInX" data-wow-delay="300ms" data-wow-duration="1500ms">
									<div class="counter-one_counter"><span class="odometer" data-count="10"></span>+</div>
									<div class="counter-one_counter-text">tour & travel awards</div>
								</div>
							</div>

							<!-- Counter Column -->
							<div class="counter-one_block col-lg-3 col-md-6 col-sm-6">
								<div class="counter-one_block-inner wow flipInX" data-wow-delay="450ms" data-wow-duration="1500ms">
									<div class="counter-one_counter"><span class="odometer" data-count="2237216"></span></div>
									<div class="counter-one_counter-text">delighted clients</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Counter One -->

	<!-- Testimonial One -->
	<section class="testimonial-one">
		<div class="auto-container">
			<div class="row clearfix">

				<!-- Testimonial One Title Column -->
				<div class="testimonial-one_title-column col-lg-4 col-md-12 col-sm-12">
					<div class="testimonial-one_title-inner">
						<!-- Sec Title -->
						<div class="sec-title">
							<h2 class="sec-title_heading">TESTIMONIALS</h2>
							<div class="sec-title-text">What our clients love about us.</div>
						</div>
					</div>
				</div>

				<!-- Testimonial One Carousel Column -->
				<div class="testimonial-one_carousel-column col-lg-8 col-md-12 col-sm-12">
					<div class="testimonial-one_carousel-inner">
						<div class="testimonial-one_pattern" style="background-image: url({{ asset('vacasky/images/icons/pattern-1.png') }})"></div>
						<div class="testimonial-carousel owl-carousel owl-theme">

							<!-- Testimonial Block One -->
							<div class="testimonial-block_one">
								<div class="testimonial-block_one-inner">
									<div class="testimonial-block_one-text">I recently booked a trip to Italy with Vacasky, and I couldn't be happier with the experience. From the initial consultation to the post-trip follow-up, everything was handled with the utmost professionalism and care. Our itinerary was perfectly tailored to our interests, and we had an amazing time exploring the country. I would highly recommend Vacasky to anyone looking for a stress-free and unforgettable travel experience.</div>
									<div class="testimonial-block_one-author">
										<div class="testimonial-block_one-author_image">
											<img src="{{ asset('vacasky/images/resource/author-1.jpg') }}" alt="" />
										</div>
										Sarah Johnson
										<span>Client from United States of America</span>
									</div>
								</div>
							</div>

							<!-- Testimonial Block One -->
							<div class="testimonial-block_one">
								<div class="testimonial-block_one-inner">
									<div class="testimonial-block_one-text">I recently booked a trip to Italy with Vacasky, and I couldn't be happier with the experience. From the initial consultation to the post-trip follow-up, everything was handled with the utmost professionalism and care. Our itinerary was perfectly tailored to our interests, and we had an amazing time exploring the country. I would highly recommend Vacasky to anyone looking for a stress-free and unforgettable travel experience.</div>
									<div class="testimonial-block_one-author">
										<div class="testimonial-block_one-author_image">
											<img src="{{ asset('vacasky/images/resource/author-1.jpg') }}" alt="" />
										</div>
										Sarah Johnson
										<span>Client from United States of America</span>
									</div>
								</div>
							</div>

							<!-- Testimonial Block One -->
							<div class="testimonial-block_one">
								<div class="testimonial-block_one-inner">
									<div class="testimonial-block_one-text">I recently booked a trip to Italy with Vacasky, and I couldn't be happier with the experience. From the initial consultation to the post-trip follow-up, everything was handled with the utmost professionalism and care. Our itinerary was perfectly tailored to our interests, and we had an amazing time exploring the country. I would highly recommend Vacasky to anyone looking for a stress-free and unforgettable travel experience.</div>
									<div class="testimonial-block_one-author">
										<div class="testimonial-block_one-author_image">
											<img src="{{ asset('vacasky/images/resource/author-1.jpg') }}" alt="" />
										</div>
										Sarah Johnson
										<span>Client from United States of America</span>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Testimonial One -->

	<!-- Video One -->
	<section class="video-one">
		<div class="outer-container">
			<div class="video-one_logo"><a href="{{ route('home') }}"><img src="{{ asset('vacasky/images/logo.png') }}" alt="" title=""></a></div>
			<div class="video-one_box wow bounce" data-wow-delay="0ms" data-wow-duration="1500ms">
				<img src="{{ asset('vacasky/images/background/1.jpg') }}" alt="" />
				<a href="https://www.pexels.com/video/l-2942803/" class="play lightbox-video"><span class="flaticon-play"><i class="ripple"></i></span></a>
			</div>
		</div>
	</section>
	<!-- End Video One -->

	<!-- Achivements One -->
	<section class="achivements-one">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<h2 class="sec-title_heading">ACHIEVEMENTS</h2>
				<div class="sec-title-text">We are recognized for exceptional travel services.</div>
			</div>
			<div class="achivement-carousel owl-carousel owl-theme">

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-award"></div>
						<h3 class="achivement-block_one-title">Travel + Leisure</h3>
						<div class="achivement-block_one-text">World's Best Tour Operator 2022 United States of America</div>
					</div>
				</div>

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-trophy"></div>
						<h3 class="achivement-block_one-title">World Travel Award</h3>
						<div class="achivement-block_one-text">Best Travel Agency 2023 United Kingdom</div>
					</div>
				</div>

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-badge"></div>
						<h3 class="achivement-block_one-title">TripAdvisor</h3>
						<div class="achivement-block_one-text">Certificate of Excellence 2021 Australia</div>
					</div>
				</div>

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-award"></div>
						<h3 class="achivement-block_one-title">Travel + Leisure</h3>
						<div class="achivement-block_one-text">World's Best Tour Operator 2022 United States of America</div>
					</div>
				</div>

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-trophy"></div>
						<h3 class="achivement-block_one-title">World Travel Award</h3>
						<div class="achivement-block_one-text">Best Travel Agency 2023 United Kingdom</div>
					</div>
				</div>

				<!-- Achivement Block One -->
				<div class="achivement-block_one">
					<div class="achivement-block_one-inner">
						<div class="achivement-block_one-icon flaticon-badge"></div>
						<h3 class="achivement-block_one-title">TripAdvisor</h3>
						<div class="achivement-block_one-text">Certificate of Excellence 2021 Australia</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End Achivements One -->

	<!-- Faq One -->
	<section class="faq-one" style="background-image: url({{ asset('vacasky/images/background/20.jpg') }})">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<h2 class="sec-title_heading">FREQUENTLY ASKED QUESTIONS</h2>
				<div class="sec-title-text">What our clients usually asked about our services and tours.</div>
			</div>
			<div class="faq-one_inner-container">

				<!-- Accordion Box -->
				<ul class="accordion-box">

					<!-- Block -->
					<li class="accordion block active-block">
						<div class="acc-btn active"><div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>What type of travel packages does Vacasky offer?</div>
						<div class="acc-content current">
							<div class="content">
								<p>Vacasky offers a wide range of travel packages to destinations around the world, including customized tours, group tours, luxury travel, adventure travel, and more. Our travel specialists work with you to create an itinerary that meets your specific needs and preferences.</p>
							</div>
						</div>
					</li>

					<!-- Block -->
					<li class="accordion block">
						<div class="acc-btn"><div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>How do I book a trip with Vacasky?</div>
						<div class="acc-content">
							<div class="content">
								<p>Vacasky offers a wide range of travel packages to destinations around the world, including customized tours, group tours, luxury travel, adventure travel, and more. Our travel specialists work with you to create an itinerary that meets your specific needs and preferences.</p>
							</div>
						</div>
					</li>

					<!-- Block -->
					<li class="accordion block">
						<div class="acc-btn"><div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>What is the payment process for Vacasky?</div>
						<div class="acc-content">
							<div class="content">
								<p>Vacasky offers a wide range of travel packages to destinations around the world, including customized tours, group tours, luxury travel, adventure travel, and more. Our travel specialists work with you to create an itinerary that meets your specific needs and preferences.</p>
							</div>
						</div>
					</li>

					<!-- Block -->
					<li class="accordion block">
						<div class="acc-btn"><div class="icon-outer"><span class="icon fa-solid fa-angle-down fa-fw"></span></div>How to cancel my booking in Vacasky?</div>
						<div class="acc-content">
							<div class="content">
								<p>Vacasky offers a wide range of travel packages to destinations around the world, including customized tours, group tours, luxury travel, adventure travel, and more. Our travel specialists work with you to create an itinerary that meets your specific needs and preferences.</p>
							</div>
						</div>
					</li>

				</ul>

			</div>
		</div>
	</section>
	<!-- End Faq One -->

	<!-- News One -->
	<section class="news-one">
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title">
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<div class="title-content">
						<h2 class="sec-title_heading">TRAVEL BLOG</h2>
						<div class="sec-title-text">Insights, tips, and stories to inspire your travels.</div>
					</div>
					<a class="news-one_more" href="{{ route('blog.index') }}">See More Articles</a>
				</div>
			</div>
			<div class="row clearfix">

				<div class="column col-lg-7 col-md-12 col-sm-12">
					<!-- News Block One -->
					<div class="news-block_one">
						<div class="news-block_one-inner">
							<div class="news-block_one-image">
								<a href="{{ route('blog.details', 'must-see-attractions-santorini') }}"><img src="{{ asset('vacasky/images/resource/news-1.jpg') }}" alt="" /></a>
							</div>
							<div class="news-block_one-content">
								<div class="news-block_one-title">travel</div>
								<h3 class="news-block_one-heading"><a href="{{ route('blog.details', 'must-see-attractions-santorini') }}">10 Must-See Attractions in Santoric Greece</a></h3>
								<div class="news-block_one-author">
									<div class="news-block_one-author_image">
										<img src="{{ asset('vacasky/images/resource/author-2.jpg') }}" alt="" />
									</div>
									Angus Smith
									<span>August 15, 2025</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="column col-lg-5 col-md-12 col-sm-12">

					<!-- News Block One -->
					<div class="news-block_one">
						<div class="news-block_one-inner">
							<div class="news-block_one-image">
								<a href="{{ route('blog.details', 'guide-hiking-swiss-alps') }}"><img src="{{ asset('vacasky/images/resource/news-2.jpg') }}" alt="" /></a>
							</div>
							<div class="news-block_one-content">
								<div class="news-block_one-title">guide</div>
								<h3 class="news-block_one-heading"><a href="{{ route('blog.details', 'guide-hiking-swiss-alps') }}">Our Beginner's Guide to Start Hiking in The Swiss Alps</a></h3>
							</div>
						</div>
					</div>

					<!-- News Block One -->
					<div class="news-block_one">
						<div class="news-block_one-inner">
							<div class="news-block_one-image">
								<a href="{{ route('blog.details', 'solo-travel-tips') }}"><img src="{{ asset('vacasky/images/resource/news-3.jpg') }}" alt="" /></a>
							</div>
							<div class="news-block_one-content">
								<div class="news-block_one-title">inspiration</div>
								<h3 class="news-block_one-heading"><a href="{{ route('blog.details', 'solo-travel-tips') }}">Solo Travel: The Best Thing You Can Do for Yourself</a></h3>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- End News One -->

@endsection
