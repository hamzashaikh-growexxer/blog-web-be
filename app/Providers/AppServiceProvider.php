<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\Eloquent\BlogRepository;
use App\Repositories\BlogImageRepositoryInterface;
use App\Repositories\Eloquent\BlogImageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(BlogImageRepositoryInterface::class, BlogImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
