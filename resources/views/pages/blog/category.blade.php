<?php /** @var App\Services\Paginator $posts */ ?>
<?php /** @var App\Category $category */ ?>

@extends('web')

@section('head')
    <x-link-feed route="blog.category.feed" :parameters="compact('category')"></x-link-feed>
    <x-link-pagination :paginator="$posts"></x-link-pagination>
@endsection

@section('content')
    <x-section>
        <h1 class="text-6xl font-black text-night-0 dark:text-white leading-none mb-8">Posts about {{ $category->slug }}</h1>
        <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 lg:gap-10 xl:gap-12 mb-8">
            @foreach($posts as $post)
                <x-post.preview :post="$post"></x-post.preview>
            @endforeach
        </div>
        <x-pagination :paginator="$posts"></x-pagination>
    </x-section>
@endsection