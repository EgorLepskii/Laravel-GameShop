<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Auth\Passwords\PasswordBrokerManager $passwordBrokerManager;

    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Auth\Passwords\PasswordBrokerManager $passwordBrokerManager, \Illuminate\Routing\Redirector $redirector)
    {
        $this->viewFactory = $viewFactory;
        $this->passwordBrokerManager = $passwordBrokerManager;
        $this->redirector = $redirector;
    }

    /**
     * Display the password reset link request view.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(
            [
            'email' => ['required', 'email'],
            ]
        );

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->passwordBrokerManager->sendResetLink($request->only('email'));

        return $status == Password::RESET_LINK_SENT
                    ? $this->redirector->back()->with('status', __($status))
                    : $this->redirector->back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
