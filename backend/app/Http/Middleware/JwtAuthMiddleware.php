<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class JwtAuthMiddleware extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function handle($request, Closure $next)
    {
        $exeption = null;

        try {
            $this->authenticate($request);
        } catch (UnauthorizedHttpException $unauthException) {
            $exeption = $unauthException;
        }

        $authService = app()->make(AuthService::class);

        if (!$authService->existInStorage($request->bearerToken()) || !empty($exeption)) {
            return new JsonResponse([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return $next($request);
    }
}
