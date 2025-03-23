<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use App\Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class UnfinishedBatchException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Batch is not finished!', DomainErrorCodes::BATCH_UNFINISHED_BATCH);
    }
}