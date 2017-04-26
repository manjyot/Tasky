<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class CheckRole
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
        if($request->user() === null){
            return Redirect::back()->with('message', 'Please login first');
        }
        $action = $request->route()->getAction();
        $roles = isset($action['roles'])? $action['roles'] : null ;

        if($request->user()->hasAnyRoles($roles) || !$roles){
            return $next($request);
        }
        return Redirect::back()->with('message', 'Insufficient permissions');
    }
}
