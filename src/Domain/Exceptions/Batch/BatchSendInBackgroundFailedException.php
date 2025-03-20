<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class BatchSendInBackgroundFailedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Failed to send batch in background!', DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);
    }
}