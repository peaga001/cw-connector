<?php

declare(strict_types=1);

namespace CwConnector\App;

//Ports
use CwConnector\Application\Ports\ITranslator;

//UseCases
use CwConnector\Application\UseCases\GetBatchResultUseCase;
use CwConnector\Application\UseCases\GetCurrentBatchStatusUseCase;
use CwConnector\Application\UseCases\SendBatchInBackgroundUseCase;
use CwConnector\Application\UseCases\SendBatchUseCase;

//Entities
use CwConnector\Domain\Entities\Batch;

//Ports
use CwConnector\Domain\Ports\IRepository;

//Exceptions
use Exception;

class ClockWiseManager
{
    private readonly GetBatchResultUseCase $getBatchResultUseCase;
    private readonly GetCurrentBatchStatusUseCase $getCurrentBatchStatusUseCase;
    private readonly SendBatchUseCase $sendBatchUseCase;
    private readonly SendBatchInBackgroundUseCase $sendBatchInBackgroundUseCase;
    private readonly ITranslator $translator;

    public function __construct(
        IRepository $repository,
        ITranslator $translator
    ){
        $this->getBatchResultUseCase        = new GetBatchResultUseCase($repository);
        $this->getCurrentBatchStatusUseCase = new GetCurrentBatchStatusUseCase($repository);
        $this->sendBatchUseCase             = new SendBatchUseCase($repository);
        $this->sendBatchInBackgroundUseCase = new SendBatchInBackgroundUseCase($repository);
        $this->translator                   = $translator;
    }

    public function getResults(string $batchId): array
    {
        try {
            $batchResult = $this->getBatchResultUseCase->execute($batchId);
            return $this->translator->translate($batchResult->toArray());
        }catch (Exception $exception) {
            var_dump($exception);
            die();
        }
    }

    public function getCurrentStatus(string $batchId): int
    {
        try {
            return $this->getCurrentBatchStatusUseCase->execute($batchId);
        }catch (Exception $exception) {
            var_dump($exception);
            die();
        }
    }

    public function send(Batch $batch)
    {
        try {
            $batchResult = $this->sendBatchUseCase->execute($batch);
            return $this->translator->translate($batchResult->toArray());
        }catch (Exception $exception) {
            var_dump($exception->getMessage());
            die();
        }
    }

    public function sendInBackground(Batch $batch): string
    {
        try {
            return $this->sendBatchInBackgroundUseCase->execute($batch);
        }catch (Exception $exception) {
            var_dump($exception);
            die();
        }
    }
}