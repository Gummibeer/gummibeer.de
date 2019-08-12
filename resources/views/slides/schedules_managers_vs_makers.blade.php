@extends('slides')

@section('content')
    @include('slides.partials.split_screen', [
        'title' => 'Schedules',
        'subtitle' => 'managers vs makers',
    ])
    @include('slides.partials.about')
    @include('slides.schedules_managers_vs_makers.definition')
    @include('slides.schedules_managers_vs_makers.planning')
    @include('slides.schedules_managers_vs_makers.distraction')
    @include('slides.schedules_managers_vs_makers.asynchronous')
    @include('slides.partials.end')
@endsection
