<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@php
    $seoTitle = $seo['title'] ?? trim($__env->yieldContent('title'));
    $seoDescription = $seo['description'] ?? trim($__env->yieldContent('description'));
    $seoCanonical = $seo['canonical'] ?? trim($__env->yieldContent('url'));
    $seoImage = $seo['image'] ?? trim($__env->yieldContent('img'));
    $seoKeywords = $seo['keywords'] ?? null;
    $seoRobots = $seo['robots'] ?? null;
    $seoSchema = $seo['schema'] ?? null;
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}" />
@if($seoKeywords)
<meta name="keywords" content="{{ $seoKeywords }}" />
@endif
@if($seoRobots)
<meta name="robots" content="{{ $seoRobots }}" />
@endif
<link rel="canonical" href="{{ $seoCanonical }}" />
<meta property="og:title" content="{{ $seoTitle }}" />
<meta property="og:description" content="{{ $seoDescription }}" />
<meta property="og:image" content="{{ $seoImage }}" />
<meta property="og:url" content="{{ $seoCanonical }}" />
<meta property="og:site_name" content="AnanthDecodesLogistics" />
<meta property="og:locale" content="en_US">
@if (Route::is('articlePage'))
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="@yield('created')" />
    <meta property="article:modified_time" content="@yield('updated')" />
@else
    <meta property="og:type" content="website" />
@endif
@if($seoSchema)
<script type="application/ld+json">{!! $seoSchema !!}</script>
@endif
<link rel="stylesheet" href="{{ asset('css/style.css?v=') . time() }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BGWKN61TJH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BGWKN61TJH');
</script>