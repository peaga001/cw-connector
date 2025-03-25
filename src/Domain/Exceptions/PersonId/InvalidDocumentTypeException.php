<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\PersonId;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

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