<?php

namespace App\Http\Middleware;

use App\Services\Interfaces\AuthServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * CheckRole constructor.
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $this->authService->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (!$user->hasRole($role)) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
        }

        return $next($request);
    }
}
