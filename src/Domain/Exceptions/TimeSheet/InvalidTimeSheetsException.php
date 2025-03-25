<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\TimeSheet;

use CwConnector\Domain\Exceptions\DomainException;
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when the provided time sheets are determined to be invalid.
 */
class InvalidTimeSheetsException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Time sheets is invalid!', DomainErrorCodes::TIME_SHEET_INVALID_TIME_SHEETS);
    }
}