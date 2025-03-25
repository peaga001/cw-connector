<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\TimeEntry;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when a date format is invalid.
 *
 * This exception is part of the domain layer and indicates that the provided date
 * does not comply with the expected format. It includes a specific error code
 * corresponding to this violation, aiding in identifying and handling this error condition.
 */
class InvalidDateException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Date format is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_DATE);
    }
}