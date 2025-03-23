<?php

declare(strict_types=1);

namespace App;

use Application\UseCases\GetBatchResultUseCase;
use Application\UseCases\GetCurrentBatchStatusUseCase;
use Application\UseCases\SendBatchInBackgroundUseCase;
use Application\UseCases\SendBatchUseCase;
use Domain\Entities\Batch;
use Domain\Ports\IRepository;
use Exception;

class ClockWiseManager
{
    private readonly GetBatchResultUseCase $getBatchResultUseCase;
    private readonly GetCurrentBatchStatusUseCase $getCurrentBatchStatusUseCase;
    private readonly SendBatchUseCase $sendBatchUseCase;
    private readonly SendBatchInBackgroundUseCase $sendBatchInBackgroundUseCase;

    public function __construct(
        IRepository $repository,
    ){
        $this->getBatchResultUseCase        = new GetBatchResultUseCase($repository);
        $this->getCurrentBatchStatusUseCase = new GetCurrentBatchStatusUseCase($repository);
        $this->sendBatchUseCase             = new SendBatchUseCase($repository);
        $this->sendBatchInBackgroundUseCase = new SendBatchInBackgroundUseCase($repository);
    }

    public function getResults(string $batchId): array
    {
        try {

            $batchResult = $this->getBatchResultUseCase->execute($batchId);
            return $batchResult->data();

        }catch (Exception $exception) {
            //
        }
    }

    public function getCurrentStatus(string $batchId): int
    {
        try {

            return $this->getCurrentBatchStatusUseCase->execute($batchId);

        }catch (Exception $exception) {
            //
        }
    }

    public function send(Batch $batch)
    {
        try {
            $batchResult = $this->sendBatchUseCase->execute($batch);
            return $batchResult->data();
        }catch (Exception $exception) {
            //
        }
    }

    public function sendInBackground(Batch $batch): string
    {
        try {

            return $this->sendBatchInBackgroundUseCase->execute($batch);
        }catch (Exception $exception) {
            //
        }
    }
}