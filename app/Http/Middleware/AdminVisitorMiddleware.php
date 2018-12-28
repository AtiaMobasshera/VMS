<?php

namespace App\Http\Middleware;

use Closure;

class AdminVisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->role!='visitor' && $request->user()->role!='admin')
            return redirect()->back();

        return $next($request);
    }
}
