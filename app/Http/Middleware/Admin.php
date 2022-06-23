<?php

namespace App\Http\Middleware;

use App\Models\FrontUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    protected FrontUser $user;
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
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->user = $this->guard->user() ?? new FrontUser(['isAdmin' => false]);

        if (!$this->user->getAttribute('isAdmin')) {
            return $this->responseFactory->make('Forbidden', 403);
        }

        return $next($request);
    }
}
