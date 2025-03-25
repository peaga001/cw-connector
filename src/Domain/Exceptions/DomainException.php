<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions;

//Exceptions
use Exception;

/**
 * Represents an exception that is thrown if a value does not adhere to a defined valid data domain.
 */
class DomainException extends Exception
{
    public function __construct(string $message = "", int $code = 0)
    {
        parent::__construct($message, $code);
    }
}