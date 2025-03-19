<?php

declare(strict_types=1);

namespace App\Domain\Exceptions\PersonId;

use App\Domain\ErrorCodes\DomainErrorCodes;
use Exception;

class InvalidDocumentTypeException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: 'Invalid document type!',
            code: DomainErrorCodes::PERSON_ID_INVALID_DOCUMENT_TYPE,
        );
    }
}