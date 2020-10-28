<?php

namespace App\View\Components;

use Astrotomic\LaravelMime\Facades\MimeTypes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use Imgix\UrlBuilder;
use InvalidArgumentException;

class Img extends Component
{
    public ?int $width;
    public ?int $height;

    private UrlBuilder $builder;
    private array $params = [];
    private string $src;
    private ?string $ratio;
    private bool $crop;

    public function __construct(
        UrlBuilder $builder,
        string $src,
        ?int $width = null,
        ?int $height = null,
        ?string $ratio = null,
        bool $crop = false
    ) {
        $this->builder = $builder;
        $this->ratio = $ratio;
        $this->crop = $crop;
        $this->setWidth($width);
        $this->setHeight($height);

        if (Str::startsWith($src, ['http://', 'https://'])) {
            throw new InvalidArgumentException(sprintf(
                'Only local images allowed - you requested "%s".',
                $src
            ));
        } else {
            $this->src = parse_url($src, PHP_URL_PATH);
        }

        if(!app()->environment('local')) {
            $this->setDefaultParams();
        }
    }

    public function render(): View
    {
        return view('components.img');
    }

    public function src(?string $format = null): string
    {
        if (app()->environment('local')) {
            return asset($this->src);
        }

        return $this->builder->createURL(
            $this->src,
            array_merge($this->params, array_filter(['fm' => $format]))
        );
    }

    public function srcSet(?string $format = null, array $options = []): string
    {
        if (app()->environment('local')) {
            return asset($this->src).' 1x';
        }

        return $this->builder->createSrcSet(
            $this->src,
            array_merge($this->params, array_filter(['fm' => $format])),
            $options
        );
    }

    protected function setHeight(?int $height): self
    {
        $this->height = $height;

        if ($height) {
            $this->params['h'] = $height;
        } else {
            unset($this->params['h']);
        }

        return $this;
    }

    protected function setWidth(?int $width): self
    {
        $this->width = $width;

        if ($width) {
            $this->params['w'] = $width;
        } else {
            unset($this->params['w']);
        }

        return $this;
    }

    protected function setDefaultParams(): void
    {
        parse_str(explode('?', mix($this->src))[1], $query);
        $this->params['cache-id'] = $query['id'];
        $this->params['cache-md5'] = hash_file('md5', public_path($this->src));
        $this->params['auto'] = 'compress';
        $this->params['fit'] = 'max';

        if ($this->ratio) {
            $this->crop = true;
            $this->params['ar'] = $this->ratio;

            if ($this->width !== null && $this->height === null) {
                $this->setHeight($this->width / explode(':', $this->ratio)[0] * explode(':', $this->ratio)[1]);
            }

            if ($this->width === null && $this->height !== null) {
                $this->setWidth($this->height / explode(':', $this->ratio)[1] * explode(':', $this->ratio)[0]);
            }
        }

        if ($this->crop ) {
            $this->params['fit'] = 'crop';
            $this->params['crop'] = 'edges';
        }
    }
}
