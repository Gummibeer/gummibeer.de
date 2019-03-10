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
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />

    <!--[if lt IE 9]>
    <script src="{{ url('js/html5shiv.min.js') }}"></script>
    <script src="{{ url('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body data-spy="scroll" data-target="#nav-menu" data-offset="164">
<header id="header" class="container">
    <nav class="navbar navbar-dark">
        <div class="navbar-header">
            <a href="{{ url() }}">Gummibeer</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="nav-menu">
            @yield('menu')
        </div>
    </nav>
</header>

<div class="container padding-0">
    <article id="content">
        @yield('content')
    </article>
    <footer id="footer">
        <div class="top">
            <div class="row">
                <div class="col-md-8">
                    <h3>Find me</h3>
                    @include('partials.sociallist')
                </div>
                <div class="col-md-4">
                    <h3>Contact me</h3>
                    <ul class="list-icons list-unstyled">
                        <li>
                            <i class="icon far fa-phone text-primary"></i>
                            +49 162 1525105
                        </li>
                        <li>
                            <i class="icon far fa-envelope text-primary"></i>
                            dev.gummibeer@gmail.com
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom">
            <ul class="copyright list-inline margin-0">
                <li>
                    &copy; Copyright 2015 - {{ date('Y') }} by Tom Witkowski. All rights reserved.
                </li>
                <li>
                    <a href="{{ url('imprint') }}">Imprint</a>
                </li>
                <li>
                    <a href="{{ url('privacy') }}">Privacy</a>
                </li>
            </ul>
        </div>
    </footer>
</div>

<script src="{{ asset('js/scripts.min.js') }}"></script>

@include('partials.schemaorg')

</body>
</html>
