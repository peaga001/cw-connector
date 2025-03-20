<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class BatchSendFailedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Failed to send batch!', DomainErrorCodes::BATCH_SEND_FAILED);
    }
}