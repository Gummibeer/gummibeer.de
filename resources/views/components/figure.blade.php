<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var Illuminate\Support\HtmlString $caption */ ?>
<?php /** @var League\CommonMark\CommonMarkConverter $markdown */ ?>

@inject('markdown', 'markdown')

<figure @if(!empty((string) $caption)) role="group" @endif {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    {{ $slot }}
    @if(!empty((string) $caption))
        <figcaption class="text-snow-20 dark:text-snow-10 text-sm text-center mt-1">
            {!! $markdown->convertToHtml($caption) !!}
        </figcaption>
    @endif
</figure>
