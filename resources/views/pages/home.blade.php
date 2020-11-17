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

    <x-section class="relative overflow-hidden">
        <x-svg.tire class="hidden md:block absolute -z-10 bottom-0 left-0 max-h-full opacity-10"/>

        <div class="sm:px-4 md:px-0 mx-auto w-full sm:max-w-screen-sm md:max-w-screen-md space-y-8">
            <div class="prose md:prose-lg lg:prose-xl">
                <h2>Biking</h2>
                <p>
                    As a compensation to my job sitting at a desk all day long and starring on a screen - I try to ride as much bike as possible.
                </p>
                <p>
                    Most of the time I'm riding my mountainbike - even if I live in Hamburg and we have no mountains.
                    I feel comfortable in the saddle, the steering and wheels provides good control on every ground and with an enormous bandwidth of gears I can keep my cadence.
                </p>
                <p>
                    On top of my daily rides to work, grocery and so on - I'm doing at least one long-trip per year.
                    And since 2019 I'm training for the triathlon bike part and also a 24h-bike-race.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 lg:gap-10 xl:gap-12">
                <x-strava.distance/>
                <x-strava.elevation/>
                <x-strava.time/>
            </div>

            <ul class="grid grid-cols-4 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-4 list-none text-center text-4xl">
                @foreach(collect(['BG', 'CZ', 'DE', 'ES', 'FR', 'PL', 'PT', 'BE', 'NL', 'DK', 'LU', 'AT', 'CH', 'IT', 'GB'])->sort() as $country)
                    <li>
                        <x-twemoji>
                            {{ \Spatie\Emoji\Emoji::countryFlag($country) }}
                        </x-twemoji>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-section>
@endsection