@extends('master')

@section('menu')
    <ul class="nav navbar-nav">
        <li>
            <a href="{{ url('/') }}">Home</a>
        </li>
    </ul>
@endsection

@section('content')
    <section class="section">
        <div class="hgroup">
            <h3>{{ $exception->getStatusText() }}</h3>
            <h2 title="Error {{ $exception->getStatusCode() }}">Error {{ $exception->getStatusCode() }}</h2>
        </div>
        <p>
            I'm sorry but you found an error. Keep it, grow it and give it a lucky life! <i class="fa-smile-o"></i>
        </p>
        <a href="{{ url() }}" class="btn btn-block btn-primary">get back to homepage</a>
    </section>
@endsection