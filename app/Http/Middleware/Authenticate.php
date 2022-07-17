<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    private \Illuminate\Contracts\Auth\Guard $guard;
    private \Illuminate\Contracts\Routing\ResponseFactory $responseFactory;
    public function __construct(\Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Contracts\Routing\ResponseFactory $responseFactory)
    {
        $this->guard = $guard;
        $this->responseFactory = $responseFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Support\Facades\Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        if ($this->guard->user()) {
            return $next($request);
        }

        return $this->responseFactory->make('', 403);
    }

}
