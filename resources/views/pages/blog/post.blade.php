<?php /** @var App\Post $post */ ?>
<?php /** @var App\Services\MetaBag $meta */ ?>

@extends('web')

@push('head')
    <link rel="index" href="{{ route('blog.index') }}">
    <x-og.article :post="$post"/>
    @if($post->author->payment_pointer)
        <meta name="monetization" content='{{ $post->author->payment_pointer }}'>
    @endif
@endpush

@section('content')
    <x-article class="markdown">
        <header class="mb-8">
            <x-img
                :src="$post->image"
                width="768"
                :ratio="16/9"
                class="mb-8"
                :alt="$post->title"
                :crop="true"/>
            <x-post.ul-categories :post="$post" class="mb-4"/>
            <x-post.aside :post="$post"/>
        </header>
        <main class="prose md:prose-lg lg:prose-xl">
            <h1>{{ $post->title }}</h1>
            {{ $post->contents }}
        </main>
        <x-post.webmentions :url="$post->url" class="markdown" class="mt-12 pt-12 border-t-2 border-snow-10"/>
    </x-article>
@endsection