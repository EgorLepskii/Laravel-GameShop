<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FrontCategory;
use App\Models\FrontProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Receive and show products on main page,
     * considering page number anb product category
     *
     * @param  FrontCategory|null $category
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function index(int $page = 1, FrontCategory $category = null): \Illuminate\Contracts\View\View
    {
        $product = new FrontProduct();

        $products = $category == null
            ? $product->getAll(($page - 1)) : $product->getAll(($page - 1), $category->getAttribute('id'));

        $productsCount = $category == null ? $product->getCount() : $product->getCount($category->getAttribute('id'));

        return $this->viewFactory->make('main', [
            'products' => $products,
            'count' => ceil($productsCount / FrontProduct::MAX_PRODUCT_COUNT),
            'category' => $category
        ]);
    }
}
