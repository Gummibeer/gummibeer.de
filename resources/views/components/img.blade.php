<figure @if(!empty((string) $slot)) role="group" @endif>
    <picture>
        <source
            type="image/webp"
            srcset="{{ (string) $src()->output('webp')->dpr(1) }} 1x, {{ (string) $src()->output('webp')->dpr(2) }} 2x"
        />
        <img
            src="{{ (string) $src() }}"
            srcset="{{ (string) $src()->dpr(1) }} 1x, {{ (string) $src()->dpr(2) }} 2x"
            width="{{ $width }}"
            height="{{ $height }}"
            loading="lazy"
            style="background-image:url({{ $base64() }});"
            {{ $attributes->merge(['class' => 'w-full h-auto bg-cover bg-no-repeat']) }}
        />
    </picture>
    @if(!empty((string) $slot))
        <figcaption>{{ $slot }}</figcaption>
    @endif
</figure>