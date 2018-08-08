<?php

namespace Aplr\Toolbox\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Exception;

class ApiException extends HttpException
{
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct(400, $message, $previous, [], 0);
    }
}
