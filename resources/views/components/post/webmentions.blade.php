<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var Illuminate\Support\Collection|App\Comment[] $webmentions */ ?>

@if($webmentions->isNotEmpty())
<footer {{ $attributes }}>
    <h2>Webmentions</h2>
    <ol class="list-none space-y-8" reversed>
    @foreach($webmentions as $webmention)
        <li>
            <article>
                <header class="flex space-x-4 items-center mb-2">
                    <a href="{{ $webmention->author->url }}" class="block">
                        <x-img
                            :src="$webmention->author->avatar"
                            width="32"
                            height="32"
                            class="rounded-full min-w-8"
                            :alt="$webmention->author->name"></x-img>
                    </a>
                    <a href="{{ $webmention->author->url }}" class="block leading-none hover:text-brand">
                        <strong>{{ $webmention->author->name }}</strong>
                    </a>
                    <a href="{{ $webmention->url }}" class="block leading-none text-snow-20 dark:text-snow-10 hover:text-brand">
                        <time datetime="{{ $webmention->date->toIso8601String() }}">
                            {{ $webmention->date->format('Y-m-d H:i') }}
                        </time>
                    </a>
                </header>
                <blockquote>{{ $webmention->contents }}</blockquote>
            </article>
        </li>
    @endforeach
    </ol>
</footer>
@endif