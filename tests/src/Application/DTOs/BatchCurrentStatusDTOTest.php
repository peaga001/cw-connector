<?php

namespace Tests\src\Application\DTOs;

use Application\DTOs\BatchCurrentStatusDTO;
use Domain\Enums\BatchStatus;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Support\CwTestCase;
use Tests\Support\Providers\BatchStatusProvider;

class BatchCurrentStatusDTOTest extends CwTestCase
{
    #[DataProviderExternal(BatchStatusProvider::class, 'all')]
    public function test_ShouldBeInstantiateCorrectly(BatchStatus $status): void
    {
        $dto = new BatchCurrentStatusDTO(
            currentStatus: $status->value
        );

        $this->assertInstanceOf(BatchCurrentStatusDTO::class, $dto);
    }

    #[DataProviderExternal(BatchStatusProvider::class, 'all')]
    public function test_ShouldReturnCorrectValuesWhenReturningInArray(BatchStatus $status): void
    {
        $dto = new BatchCurrentStatusDTO(
            currentStatus: $status->value
        );

        $this->assertEquals(['currentStatus' => $status->value], $dto->toArray());
    }
}