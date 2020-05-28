<picture>
    <source
        type="image/webp"
        srcset="
            {{ $src()->output('webp')->dpr(1)->toUrl() }} 1x,
            {{ $src()->output('webp')->dpr(2)->toUrl() }} 2x
        "
    />
    <img
        src="{{ $src()->toUrl() }}"
        srcset="
            {{ $src()->dpr(1)->toUrl() }} 1x,
            {{ $src()->dpr(2)->toUrl() }} 2x
        "
        width="{{ $width }}"
        height="{{ $height }}"
        loading="lazy"
        {{ $attributes }}
    />
</picture>