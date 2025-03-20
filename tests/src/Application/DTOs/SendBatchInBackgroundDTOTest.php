<?php

namespace Tests\src\Application\DTOs;

use Application\DTOs\SendBatchInBackgroundDTO;
use Tests\Support\CwTestCase;

class SendBatchInBackgroundDTOTest extends CwTestCase
{
    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $dto = new SendBatchInBackgroundDTO(
            batchId: $this->batchId()
        );

        $this->assertInstanceOf(SendBatchInBackgroundDTO::class, $dto);
    }

    public function test_ShouldReturnCorrectValuesWhenReturningInArray(): void
    {
        $batchId = $this->batchId();

        $dto = new SendBatchInBackgroundDTO(
            batchId: $batchId
        );

        $this->assertEquals(['batchId' => $batchId], $dto->toArray());
    }
}