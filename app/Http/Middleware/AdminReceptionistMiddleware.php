<?php

namespace App\Http\Middleware;

use Closure;

class AdminReceptionistMiddleware
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
        if($request->user()->role!='admin' && $request->user()->role!='receptionist')
            return redirect()->back();

        return $next($request);
    }
}
