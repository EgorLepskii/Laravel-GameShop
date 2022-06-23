<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Admin recipient role administration controller
 */
class AdminRecipientRoleController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Display the add new recipient role page
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.recipientRoles');
    }
}
