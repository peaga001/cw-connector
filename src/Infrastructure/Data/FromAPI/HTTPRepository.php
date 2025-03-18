<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\FromAPI;

use App\Infrastructure\Data\FromAPI\Config\IClient;
use Domain\Entities\Batch;
use Domain\Ports\IRepository;

class HTTPRepository implements IRepository
{
    public function __construct(
        private readonly IClient $client
    ){}

    public function getBatchResult(string $id): array
    {

    }

    public function getById(string $id): ?Batch
    {

    }

    public function sendBatch(Batch $batch): array
    {
        // TODO: Implement sendBatch() method.
    }

    public function sendBatchInBackground(Batch $batch): Batch
    {
        // TODO: Implement sendBatchInBackground() method.
    }
}