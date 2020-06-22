<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\HtmlString $slot */ ?>
<?php /** @var string $name */ ?>
<?php /** @var string $lang */ ?>

<div class="mb-6 mt-4" x-data="{show: true}">
    <header class="flex bg-snow-10 dark:bg-night-20 rounded-t-2 px-4 space-x-2">
        <div class="flex space-x-2 py-2">
            <span class="h-3 w-3 bg-red-500 rounded-full"></span>
            <span class="h-3 w-3 bg-yellow-500 rounded-full cursor-pointer" @click="show=!show"></span>
            <span class="h-3 w-3 bg-green-500 rounded-full cursor-pointer" @click="if($refs.code.requestFullscreen){$refs.code.requestFullscreen()}"></span>
        </div>
        <div class="flex-grow text-center leading-none text-xs truncate py-2">
            {{ $name }}
        </div>
        <div class="text-right leading-none text-xs font-bold uppercase py-2">
            {{ $lang }}
        </div>
        <button class="leading-none text-xs py-2" type="button" data-clipboard-text="{{ $slot }}" title="copy">
            <x-icon class="fa-copy"></x-icon>
        </button>
    </header>
    <section class="bg-white dark:bg-night-10 border-2 border-t-0 border-snow-10 dark:border-night-20 rounded-b-2" x-ref="code" x-show.transition="show">
        <pre><code class="language-{{ $lang }}">{{ $slot }}</code></pre>
    </section>
</div>