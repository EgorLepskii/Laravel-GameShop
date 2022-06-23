<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Routing\Redirector $redirector, \Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->redirector = $redirector;
        $this->viewFactory = $viewFactory;
    }

    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? $this->redirector->intended(RouteServiceProvider::HOME)
                    : $this->viewFactory->make('auth.verify-email');
    }
}
