<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<meta name="description" content="@yield('description')" />
<link rel="canonical" href="@yield('url')" />
<meta property="og:title" content="@yield('title')" />
<meta property="og:description" content="@yield('description')" />
<meta property="og:image" content="@yield('img')" />
<meta property="og:url" content="@yield('url')" />
<meta property="og:site_name" content="AnanthDecodesLogistics" />
<meta property="og:locale" content="en_US">
@if (Route::is('articlePage'))
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="@yield('created')" />
    <meta property="article:modified_time" content="@yield('updated')" />
@else
    <meta property="og:type" content="website" />
@endif
<link rel="stylesheet" href="{{ asset('css/style.css?v=') . time() }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
