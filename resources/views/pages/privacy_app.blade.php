@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li>
        <a href="{{ url('/') }}">Home</a>
    </li>
    <li>
        <a href="{{ url('imprint') }}">Imprint</a>
    </li>
    <li class="active">
        <a href="{{ url('privacy') }}">Privacy</a>
    </li>
</ul>
@endsection

@section('content')
<section class="section">
    <div class="hgroup">
        <h3>App Privacy Statement</h3>
        <h2 title="App Privacy">App Privacy</h2>
    </div>
    <h4>Crashlytics</h4>
    <p>
        I use <em>Crashlytics</em> in my apps to know about bugs and usage of these. I don't collect any sensitive information from the user.
        <a href="http://crashlytics.com/terms" target="_blank">Crashlytics privacy policy</a>
    </p>
</section>
@endsection