<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var App\Post $post */ ?>

<article {{ $attributes->except('post')->merge(['class' => 'rounded-4 shadow bg-white dark:bg-night-20 overflow-hidden']) }}>
    <a href="{{ $post->url }}">
        <x-img
            src="{{ $post->image }}"
            width="768"
            height="329"
            :alt="$post->title"
            :crop="true"></x-img>
    </a>
    <div class="p-4">
        <x-post.ul-categories :post="$post" class="mb-4"></x-post.ul-categories>
        <h3 class="text-2xl font-bold text-night-0 dark:text-white leading-none mb-4">
            <a href="{{ $post->url }}" class="hover:underlined">
                {{ $post->title }}
            </a>
        </h3>
        <x-post.aside :post="$post" class="mb-4 text-sm"></x-post.aside>
        <p>{{ $post->description }}</p>
    </div>
</article>