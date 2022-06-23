<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

/**
 * Admin controller
 */
class AdminController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Show page with opportunities available to administrator
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.panel');
    }
}
