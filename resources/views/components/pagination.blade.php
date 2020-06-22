<?php /** @var App\Services\Paginator $paginator */ ?>

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div>
            @if (!$paginator->onFirstPage())
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="inline-block w-10 h-10 text-center leading-10 rounded-full shadow bg-white dark:bg-night-20 hover:bg-brand hover:text-white"
                >
                    <i class="fal fa-chevron-left"></i>
                </a>
            @else
                <span class="inline-block w-10 h-10"></span>
            @endif
        </div>
        <div>
            <ul class="flex list-none space-x-4">
                @if($paginator->currentPage() !== 1)
                    <li>
                        <a
                            href="{{ $paginator->url(1) }}"
                            class="inline-block w-10 h-10 text-center leading-10 rounded-full shadow bg-white dark:bg-night-20 hover:bg-brand hover:text-white"
                        >1</a>
                    </li>
                @endif
                <li>
                    <span class="inline-block w-10 h-10 text-center leading-10 rounded-full shadow bg-brand text-white">
                        {{ $paginator->currentPage() }}
                    </span>
                </li>
                @if($paginator->currentPage() !== $paginator->lastPage())
                    <li>
                        <a
                            href="{{ $paginator->url($paginator->lastPage()) }}"
                            class="inline-block w-10 h-10 text-center leading-10 rounded-full shadow bg-white dark:bg-night-20 hover:bg-brand hover:text-white"
                        >{{ $paginator->lastPage() }}</a>
                    </li>
                @endif
            </ul>
        </div>
        <div>
            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="inline-block w-10 h-10 text-center leading-10 rounded-full shadow bg-white dark:bg-night-20 hover:bg-brand hover:text-white"
                >
                    <i class="fal fa-chevron-right"></i>
                </a>
            @else
                <span class="inline-block w-10 h-10"></span>
            @endif
        </div>
    </nav>
@endif