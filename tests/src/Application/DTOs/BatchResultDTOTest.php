<?php

namespace Tests\src\Application\DTOs;

use Application\DTOs\BatchResultDTO;
use Tests\Support\CwTestCase;

class BatchResultDTOTest extends CwTestCase
{
    public function test_ShouldBeInstantiateCorrectly(): void
    {
        $dto = new BatchResultDTO(
            result: []
        );

        $this->assertInstanceOf(BatchResultDTO::class, $dto);
    }

    public function test_ShouldReturnCorrectValuesWhenReturningInArray(): void
    {
        $dto = new BatchResultDTO(
            result: []
        );

        $this->assertEquals(['result' => []], $dto->toArray());
    }
}