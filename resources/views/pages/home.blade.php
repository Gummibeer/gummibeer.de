@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li class="active">
        <a class="smooth" href="#about">About</a>
    </li>
    <li>
        <a class="smooth" href="#biking">Biking</a>
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
    <li>
        <a class="smooth" href="#consulting">Consulting</a>
    </li>
    <li>
        <a class="smooth" href="#charity">Charity</a>
    </li>
</ul>
@endsection

@section('content')
    @foreach(['about', 'biking', 'resume', 'projects', 'games', 'pages', 'consulting', 'charity'] as $block)
        @include('pages.home.'.$block)
    @endforeach
    @include('partials.schemaorg')
@endsection
