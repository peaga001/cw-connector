<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when a specific batch is not found in the system.
 * This exception is a specialization of DomainException and is used
 * to signal an error condition related to missing batches.
 */
class BatchNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Batch not found!', DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);
    }
}