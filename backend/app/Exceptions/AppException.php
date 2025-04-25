<?php

namespace App\Exceptions;

use Throwable;

/**
 * Base app exception with text error code and additional data payload
 */
class AppException extends AbstractAppException
{
    /**
     * Additional error data
     *
     * @var array<string,mixed>|null
     */
    protected ?array $payload;

    /**
     * @param string $message
     * @param int $status
     * @param Throwable|null $previous
     * @param array<string,mixed>|list<mixed>|null $payload
     */
    public function __construct(string $message, int $status = 400, ?Throwable $previous = null, ?array $payload = null)
    {
        $this->payload = $payload;
        if (is_array($payload)) {
            $message .= ' '.json_encode($payload);
        }
        parent::__construct($message, $status, $previous);
    }

    /**
     * @return array<string,mixed>|null
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @param array<string,mixed> $payload
     *
     * @return AppException
     */
    public function setPayload(array $payload): AppException
    {
        $this->payload = $payload;

        return $this;
    }
}
