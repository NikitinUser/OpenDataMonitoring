<?php

namespace App\Exceptions;

use Throwable;

class AppValidationException extends AppException
{
    /**
     * @param string $message
     * @param Throwable|null $previous
     * @param array<string,mixed>|null $payload
     */
    public function __construct(string $message, Throwable $previous = null, ?array $payload = null)
    {
        parent::__construct($message, 422, $previous, $payload);
    }
}
