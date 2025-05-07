<?php

namespace App\Http\Middleware;

use Closure;

class ApiRequestHeaders
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
        $routename = $request->route()->getName();

        if (
            is_null($routename)
            || !in_array($routename, config('api.request.route_names_exclude_json_headers'))
        ) {
            $request->headers->add(config('api.request.json_headers'));
        }

        return $next($request);
    }
}
