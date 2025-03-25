<?php

declare(strict_types=1);

namespace CwConnector\Domain\Exceptions\PersonId;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

/**
 * Exception thrown when an invalid document type is encountered.
 *
 * This exception is typically used in scenarios where a provided
 * document type does not match expected or allowed formats.
 *
 * Extends from DomainException to represent a domain-specific error.
 */
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