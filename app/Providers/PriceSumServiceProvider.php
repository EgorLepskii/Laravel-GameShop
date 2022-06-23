<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class PriceSumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.priceSum', function ($view) {

                $userId = auth()->user()->getAuthIdentifier();

                $view->with(['price' => Order::getGeneralPrice($userId)]);
            }
        );

    }


}
