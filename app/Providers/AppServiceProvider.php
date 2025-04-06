<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ผูก middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('check_user_type', \App\Http\Middleware\CheckUserType::class);
    }

}
