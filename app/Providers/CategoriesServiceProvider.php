<?php

namespace App\Providers;

use App\Models\FrontCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CategoriesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        View::composer(
            'layouts.category', function ($view) {
                $categories = (new FrontCategory())::query()->limit(FrontCategory::MAX_SHOW_COUNT)->get();
                $view->with(['categories' => $categories]);
            }
        );
    }
}
