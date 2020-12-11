<?php /** @var Illuminate\View\ComponentAttributeBag $attributes */ ?>
<?php /** @var \Illuminate\Support\Collection|\App\Webmentions\Like[] $likes */ ?>
<?php /** @var \Illuminate\Support\Collection|\App\Webmentions\Comment[] $comments */ ?>

@if($likes->isNotEmpty())
<footer {{ $attributes->merge(['class' => 'space-y-12']) }}>
    @if($likes->isNotEmpty())
    <div class="flex space-x-3 items-center">
        <div class="flex -space-x-1 overflow-hidden">
            @foreach($likes->take(6) as $like)
            <a href="{{ $like->author->url }}" class="block h-8 w-8" title="{{ $like->author->name }}">
                <x-img
                    :src="$like->author->avatar"
                    width="64"
                    height="64"
                    ratio="1:1"
                    class="inline-block rounded-full border-2 border-solid border-white"
                    :alt="$like->author->name"
                />
            </a>
            @endforeach
        </div>

        <p class="block flex-grow text-snow-20 dark:text-snow-10">
            <x-icon class="fal mr-1 fa-heart"/>
            {{ $likes->count() }} likes
        </p>
    </div>
    @endif

    @if($comments->isNotEmpty())
    <section>
        <h2>Comments</h2>
        <ol class="list-none space-y-8" reversed>
        @foreach($comments as $comment)
            <li>
                <article>
                    <header class="flex space-x-4 items-center mb-2">
                        <a href="{{ $comment->author->url }}" class="block h-8 w-8" title="{{ $comment->author->name }}">
                            <x-img
                                :src="$comment->author->avatar"
                                width="64"
                                height="64"
                                ratio="1:1"
                                class="rounded-full min-w-8"
                                :alt="$comment->author->name"
                            />
                        </a>
                        <a href="{{ $comment->author->url }}" class="block leading-none hover:text-brand">
                            <strong>{{ $comment->author->name }}</strong>
                        </a>
                        <a href="{{ $comment->url }}" class="block leading-none text-snow-20 dark:text-snow-10 hover:text-brand">
                            <time datetime="{{ $comment->date->toIso8601String() }}">
                                {{ $comment->date->format('M jS, Y') }}
                            </time>
                        </a>
                    </header>
                    <blockquote>{{ $comment->contents }}</blockquote>
                </article>
            </li>
        @endforeach
        </ol>
    </section>
    @endif
</footer>
@endif