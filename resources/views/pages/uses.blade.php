@extends('web')

@section('content')
    <x-article class="markdown">
        {{ $contents }}
    </x-article>
@endsection