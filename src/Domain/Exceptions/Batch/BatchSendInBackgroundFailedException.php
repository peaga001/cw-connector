<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when a batch process fails to send in the background.
 *
 * This exception indicates that an attempt to send a batch operation in the background did not succeed.
 * It extends the DomainException class to provide specific context and an error code for this failure scenario.
 */
class BatchSendInBackgroundFailedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Failed to send batch in background!', DomainErrorCodes::BATCH_SEND_IN_BACKGROUND_FAILED);
    }
}