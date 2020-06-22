<?php /** @var App\Post $post */ ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>og:image</title>
    <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
</head>
<body class="min-h-screen bg-snow-0 text-night-0 relative bg-dotted">

<div class="absolute top-1/2 w-screen transform -translate-y-1/2">
    <div class="font-logo text-6xl text-brand text-center leading-none">Tom Witkowski</div>

    <div class="mx-auto w-2/3 text-center text-6xl font-bold leading-none mt-16">{{ $post->title }}</div>

    <div class="mx-auto w-2/3 text-center text-lg mt-8">{{ $post->description }}</div>
</div>

</body>
</html>
