<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AppValidationException extends AppException
{
    /**
     * @param string $message
     * @param Throwable|null $previous
     * @param array<string,mixed>|null $payload
     */
    public function __construct(string $message, Throwable $previous = null, ?array $payload = null)
    {
        parent::__construct($message, SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY, $previous, $payload);
    }
}
