<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankInfoCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        //dd($request->route()->uri(),$request->route()->uri() == 'my-account');
        if($request->route()->uri() == 'my-account'){
            return $next($request);
        }
        if( !$user->hasAnyRole('provider','representative') ){
            return $next($request);
        }

        if( !$user->bank_name || !$user->account_number || !$user->bsb_number  ){
            return redirect()->route('my.account');
        }

        return $next($request);
    }
}
