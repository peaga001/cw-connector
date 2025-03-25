<?php

declare(strict_types=1);

namespace CwConnector\Domain\Ports;

//Entities
use CwConnector\Domain\Entities\Batch;

/**
 * Interface IRepository
 *
 * Contract for the repository handling Batch operations.
 * Provides methods to retrieve, process, and send batches.
 */
interface IRepository
{
    public function getById(string $id): ?Batch;
    public function getBatchResult(string $id): ?Batch;
    public function sendBatch(Batch $batch): ?Batch;
    public function sendBatchInBackground(Batch $batch): ?Batch;
}