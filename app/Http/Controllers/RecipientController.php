<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecipientRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRecipientRequest;
use App\Models\Recipient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

class RecipientController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function store(CreateRecipientRequest $createRecipientRequest): \Illuminate\Contracts\View\View
    {
        $recipient = new Recipient($createRecipientRequest->input());
        $recipient->save();

        return $this->viewFactory->make('admin.createRecipientSuccess');
    }
}
