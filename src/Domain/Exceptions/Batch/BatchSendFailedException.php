<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when a batch sending operation fails.
 */
class BatchSendFailedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Failed to send batch!', DomainErrorCodes::BATCH_SEND_FAILED);
    }
}