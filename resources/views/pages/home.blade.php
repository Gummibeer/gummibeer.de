@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li class="active">
        <a class="smooth" href="#about">About</a>
    </li>
    <li>
        <a class="smooth" href="#resume">Resume</a>
    </li>
    <li>
        <a class="smooth" href="#projects">Projects</a>
    </li>
    <li>
        <a class="smooth" href="#games">Games</a>
    </li>
    <li>
        <a class="smooth" href="#pages">Pages</a>
    </li>
</ul>
@endsection

@section('content')
    @foreach(['about', 'resume', 'projects', 'games', 'pages'] as $block)
        @include('pages.home.'.$block)
    @endforeach
@endsection