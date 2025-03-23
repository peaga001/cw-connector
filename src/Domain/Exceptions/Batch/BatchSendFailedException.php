<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use App\Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class BatchSendFailedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Failed to send batch!', DomainErrorCodes::BATCH_SEND_FAILED);
    }
}