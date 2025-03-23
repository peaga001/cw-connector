<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use App\Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class BatchSendInBackgroundFailedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Failed to send batch in background!', DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);
    }
}