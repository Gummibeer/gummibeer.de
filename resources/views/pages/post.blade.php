<?php /** @var App\Post $post */ ?>
<?php /** @var App\Services\MetaBag $meta */ ?>

@extends('web')

@section('head')
    <link rel="index" href="{{ route('blog.index') }}">
@endsection

@section('monetization')
    @if($post->author->payment_pointer)
        <meta name="monetization" content='{{ $post->author->payment_pointer }}'>
    @endif
@endsection

@section('open-graph')
    {!!
        Astrotomic\OpenGraph\OpenGraph::article($meta->title)
            ->description($post->description)
            ->image(
                Astrotomic\OpenGraph\StructuredProperties\Image::make(route('blog.post.jpg', $post))
                    ->width(1200)
                    ->height(630)
                    ->mimeType('image/jpeg')
            )
            ->author($post->author->url)
            ->publishedAt($post->date)
            ->modifiedAt($post->modified_at)
    !!}
    {!!
        Astrotomic\OpenGraph\Twitter::summaryLargeImage($meta->title)
            ->description($post->description)
            ->image(route('blog.post.jpg', $post))
            ->site(config('app.name'))
            ->creator($post->author->name)
    !!}
@endsection

@section('content')
    <x-article class="markdown">
        <header class="mb-8">
            <x-img
                :src="$post->image"
                width="768"
                height="432"
                class="mb-8"
                :alt="$post->title"
                :crop="true"></x-img>
            <x-post.ul-categories :post="$post" class="mb-4"></x-post.ul-categories>
            <h1>{{ $post->title }}</h1>
            <x-post.aside :post="$post"></x-post.aside>
        </header>
        <main>
            {{ $post->contents }}
        </main>
        <x-post.webmentions :url="$post->url" class="markdown" class="mt-12 pt-12 border-t-2 border-snow-10"></x-post.webmentions>
    </x-article>
@endsection