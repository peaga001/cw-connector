<?php

declare(strict_types=1);

namespace CwConnector;

//Ports
use CwConnector\Application\Ports\ITranslator;
use CwConnector\Domain\Ports\IRepository;

//UseCases
use CwConnector\Application\UseCases\GetBatchResultUseCase;
use CwConnector\Application\UseCases\GetCurrentBatchStatusUseCase;
use CwConnector\Application\UseCases\SendBatchInBackgroundUseCase;
use CwConnector\Application\UseCases\SendBatchUseCase;

//Entities
use CwConnector\Domain\Entities\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;
use CwConnector\Domain\Exceptions\Batch\BatchSendFailedException;
use CwConnector\Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use CwConnector\Domain\Exceptions\Batch\UnfinishedBatchException;

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

    /**
     * @throws UnfinishedBatchException
     * @throws BatchNotFoundException
     */
    public function getResults(string $batchId): array
    {
        $batchResult = $this->getBatchResultUseCase->execute($batchId);
        return $this->translator->translate($batchResult->toArray());
    }

    /**
     * @throws BatchNotFoundException
     */
    public function getCurrentStatus(string $batchId): int
    {
        return $this->getCurrentBatchStatusUseCase->execute($batchId);
    }

    /**
     * @throws BatchSendFailedException
     */
    public function send(Batch $batch): array
    {
        $batchResult = $this->sendBatchUseCase->execute($batch);
        return $this->translator->translate($batchResult->toArray());
    }

    /**
     * @throws BatchSendInBackgroundFailedException
     */
    public function sendInBackground(Batch $batch): string
    {
        return $this->sendBatchInBackgroundUseCase->execute($batch);
    }
}