<?php

declare(strict_types=1);

namespace Infrastructure\Data\HTTP\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Unauthorized!', HTTPErrorCodes::UNAUTHORIZED);
    }
}