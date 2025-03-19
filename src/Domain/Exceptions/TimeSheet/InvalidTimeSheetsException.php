<?php

declare(strict_types=1);

namespace Domain\Exceptions\TimeSheet;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class InvalidTimeSheetsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Time sheets is invalid!', DomainErrorCodes::TIME_SHEET_INVALID_TIME_SHEETS);
    }
}