<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::check()) {
            if (auth()->user()->role == 1) {
                return $next($request);
            } else {
                abort(401, 'Unauthorized action.');
            }
        }
        return redirect('/login');
    }
}
