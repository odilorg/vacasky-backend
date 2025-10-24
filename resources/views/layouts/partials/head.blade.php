<meta charset="utf-8">
<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="shortcut icon" href="{{ asset('vacasky/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('vacasky/images/favicon.png') }}" type="image/x-icon">

<title>@yield('title', 'Vacasky - Tour & Travel Agency')</title>

<!-- SEO Meta Tags -->
<meta name="description" content="@yield('meta_description', 'Discover amazing tours and travel packages with Vacasky. Explore destinations around the world with expertly curated travel experiences.')">
<meta name="keywords" content="@yield('meta_keywords', 'travel, tours, vacation packages, travel agency, adventure tours, destinations')">
<meta name="author" content="Vacasky">
<meta name="robots" content="@yield('meta_robots', 'index, follow')">
<link rel="canonical" href="@yield('canonical_url', url()->current())">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:url" content="@yield('og_url', url()->current())">
<meta property="og:title" content="@yield('og_title', config('app.name'))">
<meta property="og:description" content="@yield('og_description', 'Discover amazing tours and travel packages with Vacasky.')">
<meta property="og:image" content="@yield('og_image', asset('vacasky/images/logo.png'))">
<meta property="og:site_name" content="Vacasky">
<meta property="og:locale" content="en_US">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="@yield('twitter_url', url()->current())">
<meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
<meta name="twitter:description" content="@yield('twitter_description', 'Discover amazing tours and travel packages with Vacasky.')">
<meta name="twitter:image" content="@yield('twitter_image', asset('vacasky/images/logo.png'))">

<!-- Additional SEO -->
<meta name="geo.region" content="@yield('geo_region', '')">
<meta name="geo.placename" content="@yield('geo_placename', '')">
<meta name="geo.position" content="@yield('geo_position', '')">
<meta name="ICBM" content="@yield('geo_position', '')">

<!-- Stylesheet  -->
<link href="{{ asset('vacasky/css/style.css') }}" rel="stylesheet">

@stack('styles')
