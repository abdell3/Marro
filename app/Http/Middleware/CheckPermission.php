<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (auth()->guest()) 
        {
            abort(403, 'Non authentifié');
        }

        if(!auth()->user()->hasPermission($permission))
        {
            abort(403, 'Vous n\'avez pas la permission');
        }

        return $next($request);
    }
}