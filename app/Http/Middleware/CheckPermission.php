<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (auth()->guest() || !auth()->user()->hasPermission($permission)) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}