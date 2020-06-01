<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:x="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @mixSri('css/app.css')
</head>
<body>
<div class="container mx-auto">
    <h1 class="font-bold text-3xl mb-4">{{ config('app.name') }}</h1>
    <p class="mb-4">
        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
    </p>

    <x-img
        src="https://source.unsplash.com/mDskFDLX16k/2048x1024"
        width="1024"
        height="512"
        alt="lazy image test"
        :crop="true"
    >This crazy lazy image component</x-img>
</div>

@mixSri('js/app.js')
</body>
</html>
