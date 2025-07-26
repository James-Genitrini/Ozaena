<?php

namespace App\Providers;

use App\Http\Controllers\CartController;
use Illuminate\Support\ServiceProvider;
use View;

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
        View::composer('*', function ($view) {
            $cartCount = CartController::getCartCount();
            $view->with('cartCount', $cartCount);
        });

    }
}
