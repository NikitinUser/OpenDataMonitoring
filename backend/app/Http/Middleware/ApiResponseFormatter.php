<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiResponseFormatter
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
        if (!in_array($request->getRequestUri(), config('api.response.routes_exclude_response_formatter'))) {
            $response = $next($request);

            if (
                ($response instanceof Response || $response instanceof JsonResponse)
                && ($request->expectsJson() || $response->headers->get('content-type') === 'application/json')
            ) {
                $data = $response->getOriginalContent();
                $responseBody = [];

                // Status code mapping
                $statusCode = $response->getStatusCode();
                $statusCode = config('api.response.status_code.map.'.$statusCode, $statusCode);
                $response->setStatusCode($statusCode);

                // Append success
                $success = $response->isSuccessful();
                $responseBody['success'] = $success;

                // Append params
                if (!empty($params = $this->getReturninigRequestParams($request))) {
                    $responseBody['params'] = $params;
                }

                if (!$success) {
                    // Error response
                    $responseBody += $data;
                } else {
                    $responseBody['data'] = &$data;
                }

                if ($response instanceof JsonResponse) {
                    $response->setData($responseBody);
                } else {
                    $response->setContent($responseBody);
                }
            }
        }

        return $response;
    }

    /**
     *
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    private function getReturninigRequestParams(Request $request): array
    {
        if (!config('api.response.params.enable', default: false)) {
            return [];
        }

        return array_diff_key(
            $request->input(default: []),
            array_flip(config('api.response.params.hidden', default: []))
        );
    }
}