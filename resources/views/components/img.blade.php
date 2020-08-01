<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var Closure $src */ ?>
<?php /** @var Closure $srcSet */ ?>

<figure @if(!empty((string) $slot)) role="group" @endif class="overflow-hidden">
    <picture>
        <source type="image/webp" srcset="{{ $srcSet('webp') }}"/>
        <img
            src="{{ $src() }}"
            srcset="{{ $srcSet() }}"
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
            loading="lazy"
            {{ $attributes->merge(['class' => 'w-full h-auto dark:opacity-75 dark:hover:opacity-100 transition-opacity duration-500 ease-out']) }}
        />
    </picture>
    @if(!empty((string) $slot))
        <figcaption class="text-snow-20 dark:text-snow-10 text-center">{{ $slot }}</figcaption>
    @endif
</figure>
