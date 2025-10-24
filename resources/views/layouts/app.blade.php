<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('layouts.partials.head')
	@stack('styles')
</head>

<body>

<div class="page-wrapper">

	@include('layouts.partials.preloader')

 	@include('layouts.partials.header')

	@yield('content')

	@include('layouts.partials.cta')

	@include('layouts.partials.footer')
	<!-- End Footer -->

</div>
<!-- End Page Wrapper -->

@include('layouts.partials.scripts')
@stack('scripts')

</body>

</html>
