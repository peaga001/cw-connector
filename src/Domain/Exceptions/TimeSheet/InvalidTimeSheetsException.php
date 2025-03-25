<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeSheet;

use Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class InvalidTimeSheetsException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Time sheets is invalid!', DomainErrorCodes::TIME_SHEET_INVALID_TIME_SHEETS);
    }
}