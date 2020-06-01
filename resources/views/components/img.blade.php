<figure @if(!empty((string) $slot)) role="group" @endif>
    <picture>
        <source
            type="image/webp"
            srcset="{{ $src('webp', 1) }} 1x, {{ $src('webp', 2) }} 2x"
        />
        <img
            src="{{ $src() }}"
            srcset="{{ $src(null, 1) }} 1x, {{ $src(null, 2) }} 2x"
            width="{{ $img()->width() }}"
            height="{{ $img()->height() }}"
            loading="lazy"
            {{ $attributes->merge(['class' => 'w-full h-auto']) }}
        />
    </picture>
    @if(!empty((string) $slot))
        <figcaption>{{ $slot }}</figcaption>
    @endif
</figure>