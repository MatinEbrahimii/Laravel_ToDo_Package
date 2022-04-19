<?php

namespace MatinEbrahimii\ToDo\Http\Middleware;

use Closure;
use MatinEbrahimii\ToDo\Models\User;
use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guard)
    {
        // if ($this->auth->guard($guard)->guest()) {
        //     return ResponderFacade::unauthorized();
        // }

        $token = $request->bearerToken();

        $user = User::where('token', $token)->first();
        if ($user) {
            auth()->login($user);
            return $next($request);
        }
        return  ResponderFacade::unauthorized();
    }

    /**
     * Get the path the User should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
