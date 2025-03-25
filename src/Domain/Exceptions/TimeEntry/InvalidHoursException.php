<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\TimeEntry;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when the hours format provided is invalid.
 *
 * This exception is specifically used to indicate that the input for hours
 * does not comply with the expected format or value constraints. It is part of
 * the domain logic error handling related to time entry validation.
 */
class InvalidHoursException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Hours format is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_HOURS);
    }
}