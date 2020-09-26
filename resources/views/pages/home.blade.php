<?php /** @var App\Services\MetaBag $meta */ ?>

@extends('web')

@push('head')
    <x-og.website/>
@endpush

@section('content')
    <x-article class="prose md:prose-lg lg:prose-xl">
        {{ $me->contents }}
    </x-article>

    @if(\App\Post::isNotEmpty())
    <x-section>
        <x-post.promo :post="\App\Post::latest()"/>
    </x-section>
    @endif

    @if(\App\Post::all()->reject(\App\Post::latest())->isNotEmpty())
    <x-section class="bg-dotted">
        <h2 class="text-4xl font-bold text-night-0 dark:text-white leading-none mb-8">Latest Posts</h2>
        <x-grid>
            @foreach(\App\Post::all()->reject(\App\Post::latest())->take(3) as $post)
                <x-post.preview :post="$post" :class="$loop->last ? 'hidden lg:block' : ''"/>
            @endforeach
        </x-grid>
    </x-section>
    @endif
@endsection