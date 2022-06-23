<?php

namespace App\Http\Controllers;

use App\Models\FrontCategory;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

/**
 * Recipient administration controller
 */
class AdminRecipientController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Display the add new recipient page
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.recipients', ['roles' => Role::all()]);
    }
}
