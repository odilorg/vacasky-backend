<!-- Footer -->
<footer class="main-footer">
	<div class="auto-container">
		<!-- Upper Box -->
		<div class="upper-box">
			<div class="d-flex align-items-center justify-content-between flex-wrap">
				<div class="footer-logo"><a href="{{ route('home') }}"><img src="{{ asset('vacasky/images/logo.png') }}" alt="" title=""></a></div>
				<ul class="footer-nav">
					<li><a href="{{ route('destinations.index') }}">Destinations</a></li>
					<li><a href="{{ route('tours.index') }}">Tours</a></li>
					<li><a href="{{ route('about') }}">About</a></li>
					<li><a href="{{ route('blog.index') }}">Blog</a></li>
					<li><a href="{{ route('contact') }}">Contact</a></li>
				</ul>
				<!-- Social Box -->
				<div class="footer-social_box">
					<a href="https://facebook.com/" class="fab fa-facebook fa-fw"></a>
					<a href="https://twitter.com/" class="fab fa-twitter-square fa-fw"></a>
					<a href="https://instagram.com/" class="fab fa-instagram fa-fw"></a>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="d-flex align-items-center justify-content-between flex-wrap">
				<div class="copyright">Copyright &copy; {{ date('Y') }} Vacasky. All rights reserved.</div>
				<ul class="footer-bottom_nav">
					<li><a href="#">Privacy policy</a></li>
					<li><a href="#">Terms & Condition</a></li>
				</ul>
			</div>
		</div>

	</div>
</footer>
