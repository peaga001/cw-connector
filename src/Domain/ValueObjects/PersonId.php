<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

//Enums
use Domain\Enums\DocumentTypes;

//Exceptions
use Domain\Exceptions\PersonId\InvalidDocumentTypeException;

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

    public function toArray(): array
    {
        return [
            'documentType' => $this->documentType->value,
            'documentNumber' => $this->documentNumber
        ];
    }
}