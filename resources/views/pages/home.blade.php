<?php /** @var App\Services\MetaBag $meta */ ?>

@extends('web')

@push('head')
    <x-og.website/>
@endpush

@section('content')
    <x-section>
        <x-post.promo :post="\App\Post::latest()"/>
    </x-section>

    <x-section class="bg-dotted">
        <h2 class="text-4xl font-bold text-night-0 dark:text-white leading-none mb-8">Latest Posts</h2>
        <x-grid>
            @foreach(\App\Post::all()->reject(\App\Post::latest())->take(3) as $post)
                <x-post.preview :post="$post" :class="$loop->last ? 'hidden lg:block' : ''"/>
            @endforeach
        </x-grid>
    </x-section>
@endsection