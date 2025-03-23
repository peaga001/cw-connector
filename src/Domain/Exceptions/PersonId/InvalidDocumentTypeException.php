<?php

declare(strict_types=1);

namespace Domain\Exceptions\PersonId;

use App\Domain\Exceptions\DomainException;
use Domain\ErrorCodes\DomainErrorCodes;

class InvalidDocumentTypeException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Invalid document type!',
            code: DomainErrorCodes::PERSON_ID_INVALID_DOCUMENT_TYPE,
        );
    }
}