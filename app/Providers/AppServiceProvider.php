<?php

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\JobRepository;
use App\Repositories\PostRepository;
use App\Services\FencedCodeRenderer;
use App\Services\MetaBag;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Imgix\UrlBuilder;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConverterInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerMeta();
        $this->registerRepositories();
        $this->registerCommonmark();
        $this->registerImgix();
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        Event::listen(RequestHandled::class, fn () => $this->registerMeta());
    }

    public function registerMeta(): void
    {
        $this->app->singleton(MetaBag::class);

        View::share('meta', $this->app->make(MetaBag::class));
    }

    public function registerRepositories(): void
    {
        $this->app->singleton(PostRepository::class);
        $this->app->singleton(AuthorRepository::class);
        $this->app->singleton(CategoryRepository::class);
        $this->app->singleton(JobRepository::class);
    }

    public function registerCommonmark(): void
    {
        $commonMark = $this->app->instance(
            CommonMarkConverter::class,
            $this->app->make(ConverterInterface::class)
        );
        $this->app->alias(CommonMarkConverter::class, 'markdown');
        $environment = $commonMark->getEnvironment();
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer());
    }

    public function registerImgix(): void
    {
        $builder = new UrlBuilder(config('services.imgix.domain'));
        $builder->setUseHttps(true);
        $builder->setIncludeLibraryParam(false);
        if (config('services.imgix.sign_key')) {
            $builder->setSignKey(config('services.imgix.sign_key'));
        }

        $this->app->instance(UrlBuilder::class, $builder);
    }
}
