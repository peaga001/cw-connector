<?php

declare(strict_types=1);

namespace Domain\Exceptions\Batch;

use App\Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class BatchNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Batch not found!', DomainErrorCodes::BATCH_NOT_FOUND_EXCEPTION);
    }
}