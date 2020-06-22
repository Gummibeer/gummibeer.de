<?php /** @var App\Services\MetaBag $meta */ ?>

@extends('web')

@section('open-graph')
{!!
     Astrotomic\OpenGraph\OpenGraph::website($meta->title)
        ->url(url()->current())
        ->when($meta->description)->description($meta->description)
        ->when($meta->image)->image($meta->image)
        ->locale(str_replace('-', '_', app()->getLocale()))
!!}
{!!
     Astrotomic\OpenGraph\Twitter::summaryLargeImage($meta->title)
        ->when($meta->description)->description($meta->description)
        ->when($meta->image)->image($meta->image)
        ->site('@devgummibeer')
        ->creator('@devgummibeer')
!!}
@endsection

@section('content')
    <x-section>
        <x-post.promo :post="App\Post::latest()"></x-post.promo>
    </x-section>

    <x-section class="bg-dotted">
        <h2 class="text-4xl font-bold text-night-0 dark:text-white leading-none mb-8">Latest Posts</h2>
        <x-grid>
            @foreach(App\Post::all()->reject(App\Post::latest())->take(3) as $post)
                <x-post.preview :post="$post" :class="$loop->last ? 'hidden lg:block' : ''"></x-post.preview>
            @endforeach
        </x-grid>
    </x-section>
@endsection