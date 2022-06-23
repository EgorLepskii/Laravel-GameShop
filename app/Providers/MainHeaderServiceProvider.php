<?php

namespace App\Providers;

use App\Models\Front\FrontProduct;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MainHeaderServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer(
            'layouts.mainHeader', function ($view) {
                $view->with([]);
            }
        );
    }
}
