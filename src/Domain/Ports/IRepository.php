<?php

declare(strict_types=1);

namespace Domain\Ports;

use Domain\Entities\Batch;

interface IRepository
{
    public function getById(string $id): ?Batch;
    public function getBatchResult(string $id): array;
    public function sendBatch(Batch $batch): ?array;
    public function sendBatchInBackground(Batch $batch): ?Batch;
}