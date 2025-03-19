<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeEntry;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class InvalidDateException extends Exception
{
    public function __construct()
    {
        parent::__construct('Date format is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_DATE);
    }
}