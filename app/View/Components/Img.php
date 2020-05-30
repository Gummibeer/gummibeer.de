<?php

namespace App\View\Components;

use Astrotomic\Weserv\Images\Enums\Fit;
use Astrotomic\Weserv\Images\Enums\Output;
use Astrotomic\Weserv\Images\Laravel\Factory;
use Astrotomic\Weserv\Images\Laravel\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;
use Illuminate\View\View;

class Img extends Component
{
    private Factory $weserv;

    private string $src;
    private ?int $width;
    private ?int $height;
    private bool $crop;

    public function __construct(
        Factory $weserv,
        string $src,
        ?int $width = null,
        ?int $height = null,
        bool $crop = false
    ) {
        $this->weserv = $weserv;
        $this->src = $src;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
    }

    public function render(): View
    {
        $json = Http::get(
            $this->src()->output(Output::JSON)->toUrl()
        )->json();

        return view('components.img', [
            'width' => $json['width'],
            'height' => $json['height'],
        ]);
    }

    public function src(): Url
    {
        return $this->weserv->make($this->src)
            ->when($this->width !== null, fn(Url $url): Url => $url->w($this->width))
            ->when($this->height !== null, fn(Url $url): Url => $url->h($this->height))
            ->we()
            ->when(
                $this->crop,
                fn(Url $url): Url => $url->fit(Fit::COVER)->align('attention')
            )
            ->when(
                !$this->crop,
                fn(Url $url): Url => $url->fit(Fit::INSIDE)
            )
        ;
    }

    public function base64(): string
    {
        return Http::get(
            $this->weserv->make($this->src()->toUrl())
                ->w(5)
                ->we()
                ->output(Output::GIF)
                ->base64()
        )->body();
    }
}
