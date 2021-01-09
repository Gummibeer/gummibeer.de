<?php /** @var App\Services\Paginator $posts */ ?>

@extends('web')

@push('head')
    <x-og.website/>
    <x-link-pagination :paginator="$posts"/>
    <x-link-feed route="blog.feed"/>
@endpush

@section('content')
    <x-section>
        <h1 class="text-6xl font-black text-night-0 dark:text-white leading-none mb-8">Blog</h1>
        <x-post.search/>
        <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 lg:gap-10 xl:gap-12 mb-8">
            @foreach($posts as $post)
                <x-post.preview :post="$post"></x-post.preview>
            @endforeach
        </div>
        <x-pagination :paginator="$posts"></x-pagination>
    </x-section>
@endsection