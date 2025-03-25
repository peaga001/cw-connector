<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\TimeEntry;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

class InvalidDateException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Date format is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_DATE);
    }
}