<?php

namespace App\Http\Middleware;

use Closure;

class HostVisitorMiddleware
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
        if($request->user()->role!='visitor' && $request->user()->role!='host')
            return redirect()->back();

        return $next($request);
    }
}
