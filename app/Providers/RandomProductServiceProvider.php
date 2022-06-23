<?php

namespace App\Providers;


use App\Models\FrontProduct;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Show random product in main page
 */
class RandomProductServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        View::composer(
            'layouts.random', function ($view) {
                $product = (new FrontProduct())::query()->inRandomOrder()->first() ?? (new FrontProduct());

                $view->with(['product' => $product]);
            }
        );
    }
}
