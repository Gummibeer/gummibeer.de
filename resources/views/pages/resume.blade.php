<?php /** @var Illuminate\Support\HtmlString $contents */ ?>
<?php /** @var Illuminate\Support\Collection|App\Job[] $jobs */ ?>

@extends('web')

@push('head')
    <x-og.profile/>
@endpush

@section('content')
    <x-article class="prose md:prose-lg lg:prose-xl">
        {{ $contents }}
    </x-article>

    <x-section class="bg-dotted">
        <div class="sm:px-4 md:px-0 mx-auto w-full sm:max-w-screen-sm md:max-w-screen-md">
            <div class="rounded-4 shadow bg-white dark:bg-night-20 overflow-hidden px-4 divide-y">
            @foreach($jobs as $job)
                <div class="py-4 @if($job->hasEnd()) text-snow-20 dark:text-snow-10 @endif">
                    <div class="flex flex-row sm:items-center sm:space-x-4">
                        @if($job->logo)
                            <div class="hidden sm:block w-24 h-24">
                                <x-img
                                    :src="$job->logo"
                                    :alt="$job->name"
                                    class="h-full w-full object-contain"
                                />
                            </div>
                        @endif
                        <div class="flex-grow">
                            <div class="flex flex-col sm:flex-row justify-between">
                                <div class="flex flex-col sm:flex-row sm:space-x-4 sm:items-center">
                                    <h3 class="text-2xl @if(!$job->hasEnd()) font-medium text-brand @endif">
                                        <x-icon :class="$job->icon"/>
                                        {{ $job->name }}
                                    </h3>
                                    <a
                                            href="{{ $job->website }}"
                                            target="_blank"
                                            class="inline-block text-snow-20 dark:text-snow-10 hover:text-brand text-xs p-1"
                                    >
                                        {{ $job->website_host }}
                                    </a>
                                </div>
                                <div class="text-sm">
                                    <time datetime="{{ $job->start_at->toIso8601String() }}">
                                        {{ $job->start_at->year }}
                                    </time>
                                    -
                                    <time datetime="{{ ($job->end_at ?? now())->toIso8601String() }}">
                                        {{ optional($job->end_at)->year ?? 'now' }}
                                    </time>
                                </div>
                            </div>
                            <strong class="block @if(!$job->hasEnd()) font-bold @else text-sm font-normal @endif">{{ $job->role }}</strong>
                            <ul class="flex list-none space-x-4 @if(!$job->hasEnd()) text-sm @else text-xs @endif mt-1">
                                @foreach($job->stack as $tool)
                                    <li>{{ $tool }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </x-section>
@endsection