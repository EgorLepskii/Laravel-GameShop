<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Events\Dispatcher $dispatcher;

    public function __construct(\Illuminate\Routing\Redirector $redirector, \Illuminate\Events\Dispatcher $dispatcher)
    {
        $this->redirector = $redirector;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirector->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            $this->dispatcher->dispatch(new Verified($request->user()));
        }

        return $this->redirector->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
