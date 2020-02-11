<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use User;
class Admin
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
          if (Auth::check()) {
            $user=Auth::user();
            if ($user->admin == 1||$user->admin == 0) 
                return $next($request);            
            else
              return redirect('admin/login');
             } 
        else 
        {
             return redirect('admin/login');
        }
    }
}
