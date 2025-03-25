<?php

declare(strict_types=1);

namespace CwConnector\Infrastructure\Data\HTTP\Exceptions;

use Exception;

/**
 * Exception thrown when an unauthorized operation is attempted.
 *
 * This exception is typically used to signal that a request
 * or action is not authorized, often accompanied by an appropriate
 * HTTP status code for unauthorized access.
 */
class UnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Unauthorized!', HTTPErrorCodes::UNAUTHORIZED);
    }
}