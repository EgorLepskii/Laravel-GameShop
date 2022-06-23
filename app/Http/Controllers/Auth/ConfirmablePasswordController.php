<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Auth\AuthManager $authManager;

    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Auth\AuthManager $authManager, \Illuminate\Routing\Redirector $redirector)
    {
        $this->viewFactory = $viewFactory;
        $this->authManager = $authManager;
        $this->redirector = $redirector;
    }

    /**
     * Show the confirm password view.
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (! $this->authManager->guard('web')->validate(
            [
            'email' => $request->user()->email,
            'password' => $request->getPassword(),
            ]
        )
        ) {
            throw ValidationException::withMessages(
                [
                'password' => __('auth.password'),
                ]
            );
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return $this->redirector->intended(RouteServiceProvider::HOME);
    }
}
