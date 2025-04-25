<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AuthenticateException extends AbstractAppException
{
    protected int $status = SymfonyResponse::HTTP_UNAUTHORIZED;
}
