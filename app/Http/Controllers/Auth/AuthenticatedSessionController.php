<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Auth\AuthManager $authManager;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Routing\Redirector $redirector, \Illuminate\Auth\AuthManager $authManager)
    {
        $this->viewFactory = $viewFactory;
        $this->redirector = $redirector;
        $this->authManager = $authManager;
    }

    /**
     * Display the login view.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest $request
     */
    public function store(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return $this->redirector->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->authManager->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->redirector->to('/');
    }
}
