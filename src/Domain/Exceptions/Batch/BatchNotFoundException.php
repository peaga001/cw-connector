<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

class BatchNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Batch not found!', DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);
    }
}