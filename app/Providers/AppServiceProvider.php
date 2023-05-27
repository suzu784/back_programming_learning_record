<?php

namespace App\Providers;

use App\Services\ChatGPTService;
use App\Services\ChatGPTServiceMock;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Services\ChatGPTServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment('testing')) {
            $this->app->bind(ChatGPTServiceInterface::class, ChatGPTServiceMock::class);
        } else {
            $this->app->bind(ChatGPTServiceInterface::class, ChatGPTService::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
