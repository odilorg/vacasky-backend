<!-- CTA One -->
<section class="cta-one" style="background-image: url({{ asset('vacasky/images/background/2.jpg') }})">
	<div class="auto-container">
		<!-- Title Box -->
		<div class="cta-one_title-box">
			<h1 class="cta-one_heading">start your adventure</h1>
			<div class="cta-one_text">Sign up for our newsletter and receive exclusive travel deals, insider tips, and destination <br> inspiration. Don't miss out on the adventure - join our mailing list today!</div>

			<!-- Subscribe Box -->
			<div class="subscribe-box">
				<form method="post" action="#">
					@csrf
					<div class="form-group">
						<input type="email" name="email" value="" placeholder="Enter your email address here ..." required>
						<button class="submit-btn theme-btn">
							Subscribe
						</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>
<!-- End CTA One -->
