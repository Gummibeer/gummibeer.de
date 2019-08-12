<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="apple-touch-icon" href="{{ url('apple-icon.png')  }}" />
    <link rel="icon" type="image/png"  href="{{ url('android-icon.png')  }}" />

    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon-16x16.png')  }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png')  }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('favicon-96x96.png')  }}" />

    <meta name="msapplication-TileImage" content="{{ url('ms-icon-144x144.png')  }}" />
    <meta name="msapplication-TileColor" content="#FFB300" />

    <meta name="theme-color" content="#FFB300" />

    <title>{{ $title }}</title>
    <meta name="description" content="I'm an enthusiastic web developer and free time gamer from Hamburg, Germany." />

    <meta name="og:url" content="{{ app('request')->fullUrl() }}" />
    <meta name="og:title" content="{{ $title }}" />
    <meta name="og:description" content="I'm an enthusiastic web developer and free time gamer from Hamburg, Germany." />
    <meta name="og:image" content="{{ url('img/og_banner.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slides.min.css') }}" />
</head>
<body id="content" class="deck-container">
<div id="deck-progress"></div>

@yield('content')

<script src="{{ asset('js/slides.min.js') }}"></script>
</body>
</html>
