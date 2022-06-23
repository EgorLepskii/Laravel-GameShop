<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Contracts\Hashing\Hasher $hasher;

    private \Illuminate\Events\Dispatcher $dispatcher;

    private \Illuminate\Auth\AuthManager $authManager;

    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Contracts\Hashing\Hasher $hasher, \Illuminate\Events\Dispatcher $dispatcher, \Illuminate\Auth\AuthManager $authManager, \Illuminate\Routing\Redirector $redirector)
    {
        $this->viewFactory = $viewFactory;
        $this->hasher = $hasher;
        $this->dispatcher = $dispatcher;
        $this->authManager = $authManager;
        $this->redirector = $redirector;
    }

    /**
     * Display the registration view.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(
            [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]
        );

        $user = FrontUser::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->hasher->make($request->getPassword()),
            ]
        );

        $this->dispatcher->dispatch(new Registered($user));

        $this->authManager->login($user);

        return $this->redirector->to(RouteServiceProvider::HOME);
    }
}
