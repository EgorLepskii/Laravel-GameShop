<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Auth\Passwords\PasswordBrokerManager $passwordBrokerManager;

    private \Illuminate\Contracts\Hashing\Hasher $hasher;

    private \Illuminate\Events\Dispatcher $dispatcher;

    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Auth\Passwords\PasswordBrokerManager $passwordBrokerManager, \Illuminate\Contracts\Hashing\Hasher $hasher, \Illuminate\Events\Dispatcher $dispatcher, \Illuminate\Routing\Redirector $redirector)
    {
        $this->viewFactory = $viewFactory;
        $this->passwordBrokerManager = $passwordBrokerManager;
        $this->hasher = $hasher;
        $this->dispatcher = $dispatcher;
        $this->redirector = $redirector;
    }

    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function create(Request $request): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(
            [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]
        );

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = $this->passwordBrokerManager->reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user) use ($request) {
            $user->forceFill(
                [
                'password' => $this->hasher->make($request->getPassword()),
                'remember_token' => Str::random(60),
                ]
            )->save();

            $this->dispatcher->dispatch(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? $this->redirector->route('login')->with('status', __($status))
                    : $this->redirector->back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
