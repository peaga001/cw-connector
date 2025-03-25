<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when an operation is attempted on a batch
 * that has not yet been completed.
 */
class UnfinishedBatchException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Batch is not finished!', DomainErrorCodes::BATCH_UNFINISHED_BATCH);
    }
}