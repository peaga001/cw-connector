<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\TimeEntry;


//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when time entries are invalid.
 *
 * This exception is used to indicate issues with time entry validation,
 * typically in scenarios where the provided time entries do not meet
 * the required format, structure, or business rules.
 */
class InvalidTimeEntriesException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Time entries is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_TIME_ENTRIES);
    }
}