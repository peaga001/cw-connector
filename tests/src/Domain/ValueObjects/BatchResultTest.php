<?php

declare(strict_types=1);

namespace Tests\src\Domain\ValueObjects;

//ValueObjects
use Domain\ValueObjects\BatchResult;

//TestingTools
use Tests\Support\CwTestCase;

class BatchResultTest extends CwTestCase
{
    public function test_ShouldInstantiateBatchResultFromConstructor(): void
    {
        $batchResult = new BatchResult(result: []);
        $this->assertInstanceOf(BatchResult::class, $batchResult);
    }

    public function test_ShouldInstantiateBatchResultFromStaticFunction(): void
    {
        $batchResult = BatchResult::create(result: []);
        $this->assertInstanceOf(BatchResult::class, $batchResult);
    }

    public function test_ShouldReturnTheValuesCorrectlyWhenCallingToArray(): void
    {
        $batchResult = BatchResult::create(result: []);

        $this->assertEquals([], $batchResult->toArray());
    }
}