<?php

namespace Aplr\Toolbox\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Guard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard) {
            Auth::shouldUse($guard);
        }

        return $next($request);
    }
}
