<?php

namespace App\View\Components;

use Astrotomic\LaravelMime\Facades\MimeTypes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use Intervention\Image\Constraint;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class Img extends Component
{
    private ImageManager $manager;
    private Image $img;

    private string $src;
    private ?int $width;
    private ?int $height;
    private bool $crop;

    private string $hash;
    private string $extension;

    public function __construct(
        ImageManager $manager,
        string $src,
        ?int $width = null,
        ?int $height = null,
        bool $crop = false
    ) {
        $this->manager = $manager;
        $this->src = $src;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;

        $this->img = $manager->make(
            Str::startsWith($src, ['http://', 'https://'])
                ? $src
                : public_path($src)
        );

        $img = $this->img();
        $this->hash = hash('md5', $img->encode('data-url'));
        $this->extension = Arr::first(MimeTypes::getExtensions($img->mime()));
        $this->width = $img->width();
        $this->height = $img->height();
    }

    public function render(): View
    {
        return view('components.img');
    }

    public function src(?string $format = null, int $dpr = 1): string
    {
        $format ??= $this->extension;
        $path = sprintf(
            'images/%s/%s-%dx%d@%dx.%s',
            substr($this->hash, 0, 2),
            $this->hash,
            $this->width,
            $this->height,
            $dpr,
            $format
        );

        $dirname = pathinfo(public_path($path), PATHINFO_DIRNAME);
        if(!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }

        if(!file_exists($path)) {
            $this->img($dpr)->save($path, 75);
        }

        return asset($path);
    }

    public function img(int $dpr = 1): Image
    {
        $img = clone $this->img;

        if ($this->width !== null && $this->height !== null && $this->crop) {
            return $img->fit($this->width * $dpr, $this->height * $dpr, fn (Constraint $constraint) => $constraint->upsize());
        }

        if ($this->width !== null) {
            $img->widen($this->width * $dpr, fn (Constraint $constraint) => $constraint->upsize());
        }

        if ($this->height !== null) {
            $img->heighten($this->height * $dpr, fn (Constraint $constraint) => $constraint->upsize());
        }

        return $img;
    }
}
