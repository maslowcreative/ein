<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \auth()->user();
        if (!$user || ($user && $user->status == 1 && $user->roles[0]->name != 'admin')) {
            return $next($request);
        }

        if ( $user && $user->status != 1 && $user->roles[0]->name == 'sub-admin') {
            \auth()->logout();
        }else
        {
            return $next($request);
        }



        // You can customize the response for unauthorized access
        return redirect('login')->with('error', 'You do not have access to this section');
    }
}
