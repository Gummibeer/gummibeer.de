<?php /** @var App\Services\MetaBag $meta */ ?>
<?php /** @var Elhebert\SubresourceIntegrity\Sri $sri */ ?>
@inject('sri', 'sri')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="dns-prefetch" href="{{ config('app.asset_url') }}" id="ASSET_URL">
    @if(config('services.imgix.domain'))
        <link rel="dns-prefetch" href="https://{{ config('services.imgix.domain') }}">
    @endif

    <title>{{ $meta->title }}</title>
    @if($meta->description)
        <meta name="description" content="{{ $meta->description }}">
    @endif

    <meta name="theme-color" content="#ffb300">
    <meta name="msapplication-TileColor" content="#ffb300">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet" crossorigin="anonymous">

    <link rel="me" href="https://twitter.com/devgummibeer">
    <link rel="me" href="https://github.com/Gummibeer">

    <link rel="webmention" href="https://webmention.io/gummibeer.dev/webmention">
    <link rel="pingback" href="https://webmention.io/gummibeer.dev/xmlrpc">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap.xml') }}">
    <link rel="canonical" href="{{ request()->url() }}">
    @stack('head')
</head>
<body class="min-h-screen bg-snow-0 text-night-0 dark:bg-night-0 dark:text-snow-0 line-numbers">
<x-menu/>

<div class="relative">
    @yield('content')
</div>

<x-footer/>

<script async defer src="{{ mix('js/app.js') }}" crossorigin="anonymous"></script>
</body>
</html>
