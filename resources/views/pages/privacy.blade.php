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
        <h3>Privacy Statement</h3>
        <h2 title="Privacy">Privacy</h2>
    </div>
    <p>Nothing. Really, for this website I collect <strong>nothing</strong> about you.</p>
</section>
@endsection