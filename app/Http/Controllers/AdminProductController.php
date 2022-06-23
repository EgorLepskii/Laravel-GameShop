<?php

namespace App\Http\Controllers;

use App\Models\FrontCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

/**
 * FrontProduct administration controller
 */
class AdminProductController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Display the add product page
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.products', ['categories' => FrontCategory::all()]);
    }
}
