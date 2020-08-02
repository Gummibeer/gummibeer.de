<?php /** @var Illuminate\Support\HtmlString $contents */ ?>
<?php /** @var array[] $projects */ ?>

@extends('web')

@push('head')
    <x-og.website/>
@endpush

@section('content')
    <x-article class="prose md:prose-lg lg:prose-xl">
        {{ $contents }}
    </x-article>

    <x-section class="bg-dotted">
        <x-grid class="xl:grid-cols-4">
            @foreach(collect($projects)->sortBy('name') as $project)
                <div class="rounded-4 shadow bg-white dark:bg-night-20 overflow-hidden">
                    @isset($project['src'])
                    <a href="{{ $project['href'] }}" target="_blank" rel="noreferrer noopener" class="block pb-1">
                        <x-img
                            :src="$project['src']"
                            width="768"
                            ratio="16:9"
                        />
                    </a>
                    @endisset
                    <div class="px-4 py-2">
                        <a href="{{ $project['href'] }}" target="_blank" rel="noreferrer noopener" class="block hover:text-brand">
                            <strong>{{ $project['name'] }}</strong>
                        </a>
                        <p class="text-sm text-snow-20 dark:text-snow-10">{{ $project['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </x-grid>
    </x-section>
@endsection