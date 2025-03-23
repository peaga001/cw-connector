<?php

namespace App\Domain\Exceptions;

use Exception;

class DomainException extends Exception
{
    public function __construct(string $message = "", int $code = 0)
    {
        parent::__construct($message, $code);
    }
}