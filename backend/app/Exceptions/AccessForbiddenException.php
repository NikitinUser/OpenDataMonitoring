<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AccessForbiddenException extends AbstractAppException
{
    protected int $status = SymfonyResponse::HTTP_FORBIDDEN;
}
