<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProcessCreateRequest
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
        if($request->role_id == Role::ROLE_PARTICIPANT && !$request->email){
            $params = $request->all();
            $email = $request->unique_identifier ?
                     $request->unique_identifier ."@participant.ein.net.au":
                     Str::random(8) ."@participant.ein.net.au";

            $request->replace(Arr::set($params, 'email',$email));
        }
        return $next($request);
    }
}
