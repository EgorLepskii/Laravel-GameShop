<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class UserProductsCountServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.userProductsCount', function ($view) {
                $userId = \auth()->id();
                $order = new Order();
                $count = $order::query()->where('userId', '=', $userId)->count();

                $view->with(['ordersCount' => $count]);
            }
        );

    }
}
