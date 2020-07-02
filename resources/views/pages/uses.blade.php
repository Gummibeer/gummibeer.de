@extends('web')

@push('head')
    <x-og.website/>
@endpush

@section('content')
    <x-article class="markdown">
        {{ $contents }}
    </x-article>
@endsection