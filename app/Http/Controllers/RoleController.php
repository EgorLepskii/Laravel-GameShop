<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Create new role
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function store(CreateRoleRequest $createRoleRequest): \Illuminate\Contracts\View\View
    {
        $role = new Role($createRoleRequest->input());
        $role->save();

        return $this->viewFactory->make('admin.createRoleSuccess');
    }
}
