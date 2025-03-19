<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class UnfinishedBatchException extends Exception
{
    public function __construct()
    {
        parent::__construct('Batch is not finished!', DomainErrorCodes::BATCH_UNFINISHED_BATCH);
    }
}