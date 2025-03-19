<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeEntry;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class InvalidTimeEntriesException extends Exception
{
    public function __construct()
    {
        parent::__construct('Time entries is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_TIME_ENTRIES);
    }
}