<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

class BatchSendInBackgroundFailedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Failed to send batch in background!', DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);
    }
}