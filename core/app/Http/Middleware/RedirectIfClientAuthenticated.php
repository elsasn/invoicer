<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfClientAuthenticated {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next,$guard = 'user')
	{
        if (auth()->guard($guard)->check()){
            return $next($request);
        }
        return redirect('/clientarea/login')->withErrors('login', 'Please Login to access cliant area');
	}
}
