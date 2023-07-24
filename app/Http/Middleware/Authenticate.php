<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->cookie('laravel_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->cookie('laravel_token'));
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
