<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    private \Illuminate\Auth\AuthManager $authManager;
    private \Illuminate\Routing\Redirector $redirector;
    public function __construct(\Illuminate\Auth\AuthManager $authManager, \Illuminate\Routing\Redirector $redirector)
    {
        $this->authManager = $authManager;
        $this->redirector = $redirector;
    }
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param  string|null                                                                                       ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($this->authManager->guard($guard)->check()) {
                return $this->redirector->to(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
