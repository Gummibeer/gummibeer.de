<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var string $name */ ?>
<?php /** @var string $lang */ ?>

<div class="mb-6 mt-4">
    <header class="flex bg-snow-10 dark:bg-night-20 rounded-t-2 px-4 space-x-2">
        <div class="text-right leading-none text-xs font-bold uppercase py-2">
            {{ $lang }}
        </div>
        <div class="font-mono flex-grow text-center leading-none text-xs truncate py-2">
            {{ $name }}
        </div>
        <button class="leading-none text-xs py-2" type="button" data-clipboard-text="{{ $slot }}" title="copy">
            <x-icon class="fal fa-copy"/>
        </button>
    </header>
    <section class="bg-white dark:bg-night-10 border-2 border-t-0 border-snow-10 dark:border-night-20 rounded-b-2">
        <pre><code class="language-{{ $lang }}">{{ $slot }}</code></pre>
    </section>
</div>