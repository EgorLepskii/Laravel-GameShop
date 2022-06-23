<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Routing\Redirector $redirector)
    {
        $this->redirector = $redirector;
    }

    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirector->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->redirector->back()->with('status', 'verification-link-sent');
    }
}
