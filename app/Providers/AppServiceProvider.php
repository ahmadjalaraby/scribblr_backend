<?php

namespace App\Providers;

use App\Mixins\StrMixin;
use App\Services\UploadFileService;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UploadFileService::class, function ($app) {
            return new UploadFileService();
        });
    }

    /**
     * Bootstrap any application services.
     * @throws ReflectionException
     */
    public function boot(): void
    {
        LaravelJsonApi::defaultApi('v1');

        // create a macro for string values: The macro will add a slash in the beginning or in the last.
        Str::mixin(new StrMixin);
    }
}
