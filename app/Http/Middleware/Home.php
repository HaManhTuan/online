<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Home {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		
		if (Auth::guard('customers')->check()) {
			return $next($request);
		} else {
			return redirect('/login-register');
		}
	}
}
