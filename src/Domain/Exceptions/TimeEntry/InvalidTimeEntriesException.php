<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeEntry;


//Exceptions
use Domain\Exceptions\DomainException;

//ErrorCodes
use Domain\ErrorCodes\DomainErrorCodes;

class InvalidTimeEntriesException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Time entries is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_TIME_ENTRIES);
    }
}