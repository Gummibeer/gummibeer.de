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
        <div
                class="space-y-2 mb-4 md:mb-8 lg:mb-10 xl:mb-12"
                x-data="window.search"
        >
            <input
                type="search"
                name="search"
                placeholder="Search &mldr;"
                autocomplete="off"
                @input.debounce.250ms="search"
                x-model="query"
                class="px-4 py-2 w-full bg-white dark:bg-night-10 border-b-2 border-night-10 dark:border-snow-10 rounded-1 focus:outline-none focus:border-brand shadow"
            />
            <ol class="list-none space-y-2" :class="{'hidden': results.length == 0}">
                <template x-for="result in results">
                    <li class="rounded-1 shadow bg-white dark:bg-night-20 overflow-hidden p-4">
                        <a :href="result.url" class="block group">
                            <div class="flex justify-between sm:justify-start space-x-2">
                                <strong x-text="result.title" class="group-hover:text-brand"></strong>
                                <span class="text-snow-20 dark:text-snow-10">
                                    <x-icon class="fal mr-1 fa-calendar"/>
                                    <time x-text="result.date"></time>
                                </span>
                            </div>
                            <p class="truncate" x-text="result.description"></p>
                        </a>
                    </li>
                </template>
            </ol>
        </div>
        <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 lg:gap-10 xl:gap-12 mb-8">
            @foreach($posts as $post)
                <x-post.preview :post="$post"></x-post.preview>
            @endforeach
        </div>
        <x-pagination :paginator="$posts"></x-pagination>
    </x-section>
@endsection