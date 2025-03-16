<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use App\Domain\Exceptions\PersonId\InvalidDocumentTypeException;
use Domain\Enums\DocumentTypes;

class PersonId
{
    public function __construct(
        private readonly DocumentTypes $documentType,
        private readonly string $documentNumber
    ){}

    /**
     * @throws InvalidDocumentTypeException
     */
    public static function create(int $documentType, string $documentNumber): self
    {
        $documentType = DocumentTypes::tryFrom($documentType);

        if(!$documentType){
            throw new InvalidDocumentTypeException;
        }

        return new self(
            documentType: $documentType, documentNumber: $documentNumber
        );
    }

    /**
     * @throws InvalidDocumentTypeException
     */
    public function isEqual(int $documentType, string $documentNumber): bool
    {
        $documentType = DocumentTypes::tryFrom($documentType);

        if(!$documentType){
            throw new InvalidDocumentTypeException;
        }

        return $documentNumber === $this->documentNumber &&
            $documentType->value === $this->documentType->value;
    }

    public function getType(): DocumentTypes
    {
        return $this->documentType;
    }

    public function getNumber(): string
    {
        return $this->documentNumber;
    }
}