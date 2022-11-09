<?php

namespace App\Http\Middleware;

use Closure;
// use App\Models\RoleUser;
use App\Models\Role;
use App\Models\User;
use Auth;

class RoleVerify
{
    public function handle($request, Closure $next,$guard = null)
    {
      switch (true) {
        // case strpos($request->fullUrl(),'admin'):
        // if (!auth()->user()->role() == "guest" || Auth::user()->role() == "scanner") {
        //   return abort(404);
        // }
        // break;
        // case strpos($request->fullUrl(),'scanner'):
        // if (!auth()->user()->role() == "guest") {
        //   return abort(404);
        // }
        // break;
        case strpos($request->fullUrl(),'tiers'):
        // dd(auth()->user());
        // dd(auth()->user()->hasPermissionTo('tier-list'));
        if (!auth()->user()->hasPermissionTo('tier-list')) {
          return abort(404);
        }
        break;

        default:

        break;
      }

      return $next($request);
    }
}
