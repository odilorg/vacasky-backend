<!-- Main Header -->
<header class="header header_style_one">
	<div class="middle_bar">
		<div class="auto-container">
			<div class="middle_bar_inner d-flex align-items-center justify-content-center justify-content-between gap-4 flex-wrap">
				<!-- Logo -->
				<div class="logo">
					<a href="{{ route('home') }}" class="logo_default"><img src="{{ asset('vacasky/images/logo.png') }}" alt="img"></a>
					<a href="{{ route('home') }}" class="logo_sticky"><img src="{{ asset('vacasky/images/sticky-logo.png') }}" alt="img"></a>
				</div>
				<div class="mainnav d-none d-lg-block">
					<ul class="main_menu">
						<li class="menu-item menu-item-has-children"><a href="#">Home</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="{{ route('home') }}">Homepage v1</a></li>
								<li class="menu-item"><a href="{{ route('home.v2') }}">Homepage v2</a></li>
								<li class="menu-item"><a href="{{ route('home.v3') }}">Homepage v3</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Tour</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="{{ route('tours.index') }}">Tour Grid</a></li>
								<li class="menu-item"><a href="{{ route('tours.list') }}">Tour List</a></li>
								<li class="menu-item"><a href="#">Tour Details</a></li>
								<li class="menu-item"><a href="#">Tour Booking</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Hotels</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="#">Hotels</a></li>
								<li class="menu-item"><a href="#">Hotel Details</a></li>
								<li class="menu-item"><a href="#">Hotel Booking</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Destination</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="{{ route('destinations.index') }}">Destinations</a></li>
								<li class="menu-item"><a href="#">Destination Details</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Pages</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="{{ route('about') }}">About</a></li>
								<li class="menu-item"><a href="{{ route('contact') }}">Contact</a></li>
								<li class="menu-item"><a href="{{ route('login') }}">Login</a></li>
								<li class="menu-item"><a href="{{ route('signup') }}">Signup</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Blog</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="{{ route('blog.index') }}">Our Blog</a></li>
								<li class="menu-item"><a href="#">Blog Detail</a></li>
							</ul>
						</li>

						<li class="menu-item menu-item-has-children"><a href="#">Dashboard</a>
							<ul class="sub-menu">
								<li class="menu-item"><a href="#">Admin Dashboard</a></li>
								<li class="menu-item"><a href="#">User Dashboard</a></li>
							</ul>
						</li>
					</ul>
				</div>

				<div class="other_elements_wrapper d-flex align-items-center gap-4">
					<!-- Button Box -->
					<div class="button-box d-none d-sm-block">
						<a class="btn-style-one theme-btn" href="{{ route('login') }}">
							<div class="btn-wrap">
								<span class="text-one">Sign In</span>
								<span class="text-two">Sign In</span>
							</div>
						</a>
						<a class="btn-style-two theme-btn" href="{{ route('login') }}">
							<div class="btn-wrap">
								<span class="text-one">Sign In</span>
								<span class="text-two">Sign In</span>
							</div>
						</a>
					</div>

					<!-- Mobile Menu Toggle Button -->
					<div class="mr_menu_toggle d-lg-none">
						<span class="toggle_line"></span>
						<span class="toggle_line"></span>
						<span class="toggle_line"></span>
					</div>

				</div>
			</div>
		</div>
	</div>
</header>
