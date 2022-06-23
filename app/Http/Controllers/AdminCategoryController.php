<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

/**
 * FrontCategory administrator controller
 */
class AdminCategoryController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Show page that allows to add new category
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.categories', []);
    }
}
