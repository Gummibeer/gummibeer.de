<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>

<figure @if(!empty((string) $slot)) role="group" @endif class="overflow-hidden">
    <picture>
        <source
            type="image/webp"
            srcset="{{ $src('webp', 1) }} 1x, {{ $src('webp', 2) }} 2x"
        />
        <img
            src="{{ $src() }}"
            srcset="{{ $src(null, 1) }} 1x, {{ $src(null, 2) }} 2x"
            width="{{ $width }}"
            height="{{ $height }}"
            loading="lazy"
            {{ $attributes->merge(['class' => 'w-full h-auto dark:opacity-75 dark:hover:opacity-100 transition-opacity duration-500 ease-out']) }}
        />
    </picture>
    @if(!empty((string) $slot))
        <figcaption class="text-snow-20 dark:text-snow-10 text-center">{{ $slot }}</figcaption>
    @endif
</figure>