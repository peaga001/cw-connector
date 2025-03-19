<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeEntry;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class InvalidHoursException extends Exception
{
    public function __construct()
    {
        parent::__construct('Hours format is invalid!', DomainErrorCodes::TIME_ENTRY_INVALID_HOURS);
    }
}