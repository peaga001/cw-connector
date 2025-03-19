<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class BatchNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Batch not found!', DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);
    }
}