<?php

namespace App\Http\Middleware;

use App\Services\Interfaces\AuthServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * CheckPermission constructor.
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
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $this->authService->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (!$user->hasPermission($permission)) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
        }

        return $next($request);
    }
}
