@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li>
        <a href="{{ url('/') }}">Home</a>
    </li>
    <li>
        <a href="{{ url('imprint') }}">Imprint</a>
    </li>
    <li>
        <a href="{{ url('privacy') }}">Privacy</a>
    </li>
</ul>
@endsection

@section('content')
<section class="section">
    <div class="hgroup">
        <h3>{{ Illuminate\Support\Str::title(str_replace('-', ' ', $slug)) }}</h3>
        <h2 title="Blog">Blog</h2>
    </div>

    {!! (new League\CommonMark\CommonMarkConverter)->convertToHtml($content) !!}
</section>
@endsection