<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

abstract class AbstractAppException extends Exception
{
    /**
     * @var int
     */
    protected int $status = SymfonyResponse::HTTP_BAD_REQUEST;

    /**
     * @param string $message
     * @param int|null $status
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $status = null, Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
        if (isset($status)) {
            $this->status($status);
        }
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function status(int $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $this->getMessage(),
            ],
            $this->status
        );
    }
}
