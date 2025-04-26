<?php

namespace App\Http\Controllers\Responses;

use App\Exceptions\AbstractAppException;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorResponseHandler
{
    public function handle($request, Throwable $e): void
    {
        if ($e instanceof ValidationException) {
            return response()->error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->error('Ресурс не найден', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof AuthenticationException) {
            return response()->error('Не авторизован', Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof AbstractAppException) {
            return response()->error($e->getMessage(), $e->getStatus());
        }

        return response()->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
