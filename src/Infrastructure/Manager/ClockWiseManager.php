<?php

declare(strict_types=1);

namespace App\Infrastructure\Manager;

use Application\UseCases\GetBatchResultUseCase;
use Application\UseCases\GetCurrentBatchStatusUseCase;
use Application\UseCases\SendBatchInBackgroundUseCase;
use Application\UseCases\SendBatchUseCase;
use Domain\Entities\Batch;
use Exception;

class ClockWiseManager
{
    public function __construct(
        private readonly GetBatchResultUseCase $getBatchResultUseCase,
        private readonly GetCurrentBatchStatusUseCase $getCurrentBatchStatusUseCase,
        private readonly SendBatchUseCase $sendBatchUseCase,
        private readonly SendBatchInBackgroundUseCase $sendBatchInBackgroundUseCase
    ){}

    public function getResults(string $batchId): array
    {
        try {

            $batchResult = $this->getBatchResultUseCase->execute($batchId);
            return $batchResult->toArray();
        }catch (Exception $exception) {
            //
        }
    }

    public function getCurrentStatus(string $batchId): array
    {
        try {

            $batchResult = $this->getCurrentBatchStatusUseCase->execute($batchId);
            return $batchResult->toArray();
        }catch (Exception $exception) {
            //
        }
    }

    public function send(Batch $batch)
    {
        try {

            $batchResult = $this->sendBatchUseCase->execute($batch);
            return $batchResult->toArray();
        }catch (Exception $exception) {
            //
        }
    }

    public function sendInBackground(Batch $batch)
    {
        try {

            $batchResult = $this->sendBatchInBackgroundUseCase->execute($batch);
            return $batchResult->toArray();
        }catch (Exception $exception) {
            //
        }
    }
}