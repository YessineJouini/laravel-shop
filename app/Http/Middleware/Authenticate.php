<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;

class Authenticate
{
    /**
     * Handle an incoming request by checking if the user is authenticated.
     *
     * This middleware is responsible for ensuring that the user is authenticated before proceeding with the request.
     * If the user is not authenticated (i.e., a guest), an AuthenticationException is thrown.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request.
     * @param  \Closure  $next  The next middleware in the pipeline.
     * @param  string|null  ...$guards  The guards to use for the authentication (optional).
     * @return mixed  The response from the next middleware or the request itself.
     * 
     * @throws \Illuminate\Auth\AuthenticationException  If the user is not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if the user is a guest (not authenticated).
        if (auth()->user()) {
            // Throw an AuthenticationException if the user is not authenticated.
            throw new AuthenticationException('Unauthenticated.');
        }

        // Allow the request to proceed to the next middleware or the controller if authenticated.
        return $next($request);
    }
}
