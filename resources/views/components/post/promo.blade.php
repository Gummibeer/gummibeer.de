<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var App\Post $post */ ?>

<article {{ $attributes->except('post')->merge(['class' => 'md:flex md:space-x-8 lg:space-x-10 xl:space-x-12 md:items-center']) }}>
    @if($post->image)
    <div class="w-full md:w-1/2 lg:w-1/3 mb-8 md:mb-0">
        <a href="{{ $post->url }}">
            <x-img
                src="{{ $post->image }}"
                width="768"
                ratio="16:9"
                :alt="$post->title"
                class="rounded-4 shadow"
                :crop="true"/>
        </a>
    </div>
    @endif
    <div class="w-full md:w-1/2 lg:w-2/3">
        @if($post->categories()->isNotEmpty())
            <x-post.ul-categories :post="$post" class="mb-8 md:text-xl"/>
        @endif
        <h3 class="text-3xl font-bold text-night-0 dark:text-white leading-none mb-8">
            <a href="{{ $post->url }}" class="hover:underlined">
                {{ $post->title }}
            </a>
        </h3>
        <x-post.aside :post="$post" class="mb-4"/>
        <p>{{ $post->description }}</p>
    </div>
</article>