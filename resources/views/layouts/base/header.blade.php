{{-- SEO HEAD - Generado automáticamente por SeoProfileService --}}
@php($_seo = $_seo ?? [])

{{-- Canonical + Fonts --}}
<link rel="canonical" href="{{ $_seo['canonical'] ?? url()->current() }}" />
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" />

{{-- Charset (el viewport va en layout, no en SEO) --}}
<meta charset="utf-8">

{{-- hreflang alternates (multi-language SEO) --}}
@foreach ($_seo['hreflangs'] ?? [] as $lang => $url)
    <link rel="alternate" hreflang="{{ $lang }}" href="{{ $url }}" />
@endforeach

{{-- Título + SEO Meta --}}
<title>{{ $_seo['title'] ?? config('app.name') }}</title>
<meta name="description" content="{{ $_seo['description'] ?? '' }}">
<meta name="robots" content="{{ $_seo['robots'] ?? 'index, follow' }}">
<meta name="language" content="{{ $_seo['language'] ?? app()->getLocale() }}">
<meta name="author" content="{{ $_seo['author'] ?? 'Koneko Team' }}">
<meta name="keywords" content="{{ $_seo['keywords'] ?? '' }}">
<meta name="distribution" content="global">
<meta name="revisit-after" content="7 days">
<meta name="copyright" content="{{ $_seo['author'] ?? 'Koneko' }}">

{{-- CSRF (Laravel) --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- OpenGraph --}}
<meta property="og:title" content="{{ $_seo['og:title'] ?? $_seo['title'] ?? '' }}">
<meta property="og:site_name" content="{{ $_seo['og:site_name'] ?? config('app.name') }}">
<meta property="og:url" content="{{ $_seo['og:url'] ?? url()->current() }}">
<meta property="og:description" content="{{ $_seo['og:description'] ?? $_seo['description'] ?? '' }}">
<meta property="og:type" content="{{ $_seo['og:type'] ?? 'website' }}">
<meta property="og:image" content="{{ $_seo['og:image'] ?? '' }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $_seo['twitter:card'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $_seo['twitter:title'] ?? $_seo['title'] ?? '' }}">
<meta name="twitter:description" content="{{ $_seo['twitter:description'] ?? $_seo['description'] ?? '' }}">
<meta name="twitter:image" content="{{ $_seo['twitter:image'] ?? $_seo['og:image'] ?? '' }}">
<meta name="twitter:site" content="{{ $_seo['twitter:site'] ?? '' }}">
<meta name="twitter:creator" content="{{ $_seo['twitter:creator'] ?? '' }}">

{{-- Favicons dinámicos --}}
@foreach ($_seo['favicon'] ?? [] as $size => $path)
    @php($fullPath = Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/' . $path))
    @switch(true)
        @case(Str::endsWith($path, '.svg'))
            <link rel="icon" type="image/svg+xml" sizes="{{ $size }}" href="{{ $fullPath }}">
            @break
        @case(Str::endsWith($path, '.apng'))
            <link rel="icon" type="image/apng" sizes="{{ $size }}" href="{{ $fullPath }}">
            @break
        @case(Str::startsWith($size, 'apple'))
            <link rel="apple-touch-icon" sizes="{{ Str::after($size, 'apple-') }}" href="{{ $fullPath }}">
            @break
        @default
            <link rel="icon" type="image/png" sizes="{{ $size }}" href="{{ $fullPath }}">
    @endswitch
@endforeach

{{-- Web App Manifest --}}
<link rel="manifest" href="{{ $_seo['manifest'] ?? asset('site.webmanifest') }}">
<meta name="theme-color" content="{{ $_seo['theme-color'] ?? '#ffffff' }}">

{{-- JSON-LD Structured Data --}}
@if (!empty($_seo['ld+json']))
    <script type="application/ld+json">@json($_seo['ld+json'])</script>
@endif
