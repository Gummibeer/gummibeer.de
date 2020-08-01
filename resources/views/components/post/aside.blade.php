<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var App\Post $post */ ?>

<aside {{ $attributes->except('post')->merge(['class' => 'text-snow-20 dark:text-snow-10']) }}>
    <ul class="flex flex-col sm:flex-row list-none sm:space-x-3">
        <li>
            <x-icon class="fa-calendar"/>
            <a href="{{ route('blog.year.index', $post->date->year) }}" class="hover:text-brand">
                <time datetime="{{ $post->date->format('Y-m-d') }}">
                    {{ $post->date->format('M jS, Y') }}
                </time>
            </a>
        </li>
        <li>
            <x-icon class="fa-clock"/>
            {{ $post->read_time }} min read
        </li>
{{--        <li>--}}
{{--            <x-icon class="fa-user"/>--}}
{{--            <a href="{{ $post->author->url }}" class="hover:text-brand">{{ $post->author->name }}</a>--}}
{{--        </li>--}}
    </ul>
</aside>