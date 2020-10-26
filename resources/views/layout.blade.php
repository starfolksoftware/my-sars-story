<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ $meta['title'] }}">
    <meta name="description" content="{{ $meta['summary'] ?? $meta['summaryFromBody'] }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $meta['url'] }}">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['summary'] ?? $meta['summaryFromBody'] }}">
    <meta property="og:image" content="{{ 'https://' . env('APP_URL') . $meta['image'] }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $meta['url'] }}">
    <meta property="twitter:title" content="{{ $meta['title'] }}">
    <meta property="twitter:description" content="{{ $meta['summary'] ?? $meta['summaryFromBody'] }}">
    <meta property="twitter:image" content="{{ 'https://' . env('APP_URL') . $meta['image'] }}">

    <meta name="google" content="notranslate">

    @stack('meta')

    <title>{{ $currentTenant['platform']['display_name'] ?? $currentTenant['platform']['name'] }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Karla|Merriweather:400,700,900">

    <link rel="stylesheet" id="baseStylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" id="highlightStylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/styles/github.min.css">

    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/highlight.min.js"></script>
    <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

    <link rel="shortcut icon" href="{{ mix('favicon.ico') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

@javascript('CurrentTenant', $currentTenant)

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
