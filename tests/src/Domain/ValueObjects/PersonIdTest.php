<?php

namespace Tests\src\Domain\ValueObjects;

use App\Domain\ErrorCodes\DomainErrorCodes;
use App\Domain\Exceptions\PersonId\InvalidDocumentTypeException;
use Domain\Enums\DocumentTypes;
use Domain\ValueObjects\PersonId;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\BaseTestCase;
use Tests\Providers\DocumentTypesProvider;

class PersonIdTest extends BaseTestCase
{
    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_ShouldInstantiatePersonIdFromDocumentTypeEnum(DocumentTypes $documentType): void
    {
        $personId = new PersonId(
            documentType: $documentType,
            documentNumber: $this->faker->documentNumber()
        );

        $this->assertInstanceOf(PersonId::class, $personId);
    }


    /**
     * @throws InvalidDocumentTypeException
     */
    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_ShouldInstantiatePersonIdFromDocumentTypeNumber(DocumentTypes $documentType): void
    {
        $personId = PersonId::create(
            documentType: $documentType->value,
            documentNumber: $this->faker->documentNumber()
        );

        $this->assertInstanceOf(PersonId::class, $personId);
    }

    public function test_ShouldThrowExceptionWhenDocumentTypeIsInvalid(): void
    {
        $invalidDocumentType = 1000;

        $this->expectException(InvalidDocumentTypeException::class);
        $this->expectExceptionMessage('Invalid document type!');
        $this->expectExceptionCode(DomainErrorCodes::INVALID_DOCUMENT_TYPE);

        $personId = PersonId::create(
            documentType: $invalidDocumentType,
            documentNumber: $this->faker->documentNumber()
        );

        $this->assertInstanceOf(PersonId::class, $personId);
    }

    /**
     * @throws InvalidDocumentTypeException
     */
    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_MustBeTrueWhenCompareToTheValues(DocumentTypes $documentType): void
    {
        $documentNumber = $this->faker->documentNumber();

        $personId = new PersonId(
            documentType: $documentType,
            documentNumber: $documentNumber
        );

        $isEqual = $personId->isEqual(
            documentType: $documentType->value,
            documentNumber: $documentNumber
        );

        $this->assertTrue($isEqual);
    }

    /**
     * @throws InvalidDocumentTypeException
     */
    public function test_MustBeFalseWhenCompareToDifferentDocumentType(): void
    {
        $documentNumber = $this->faker->documentNumber();

        $personId = new PersonId(
            documentType: DocumentTypes::CPF,
            documentNumber: $documentNumber
        );

        $isEqual = $personId->isEqual(
            documentType: DocumentTypes::EMPLOYEE_ID->value,
            documentNumber: $documentNumber
        );

        $this->assertFalse($isEqual);
    }

    /**
     * @throws InvalidDocumentTypeException
     */
    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_MustBeFalseWhenCompareToDifferentDocumentNumber(DocumentTypes $documentType): void
    {
        $documentNumber = $this->faker->documentNumber();
        $differentDocumentNumber = (string) ((int) $documentNumber + 1);

        $personId = new PersonId($documentType, $differentDocumentNumber);

        $isEqual = $personId->isEqual(
            documentType: $documentType->value,
            documentNumber: $documentNumber
        );

        $this->assertFalse($isEqual);
    }

    /**
     * @throws InvalidDocumentTypeException
     */
    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_ShouldThrowExceptionWhenComparingInvalidDocumentType(DocumentTypes $documentType): void
    {
        $this->expectException(InvalidDocumentTypeException::class);
        $this->expectExceptionMessage('Invalid document type!');
        $this->expectExceptionCode(DomainErrorCodes::INVALID_DOCUMENT_TYPE);

        $personId = new PersonId(
            documentType: $documentType,
            documentNumber: $this->faker->documentNumber()
        );

        $personId->isEqual(
            documentType: 9999,
            documentNumber: $this->faker->documentNumber()
        );
    }

    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_ShouldReturnDocumentType(DocumentTypes $documentType): void
    {
        $personId = new PersonId(
            documentType: $documentType,
            documentNumber: $this->faker->documentNumber()
        );

        $this->assertEquals($documentType, $personId->getType());
    }

    #[DataProviderExternal(DocumentTypesProvider::class, 'all')]
    public function test_ShouldReturnDocumentNumber(DocumentTypes $documentType): void
    {
        $documentNumber = $this->faker->documentNumber();

        $personId = new PersonId(
            documentType: $documentType,
            documentNumber: $documentNumber
        );

        $this->assertEquals($documentNumber, $personId->getNumber());
    }
}