<?php

declare(strict_types=1);

namespace CwConnector\Manager;

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

/**
 * Class ClockWiseManager
 *
 * A class responsible for managing the processing of batches, including retrieving results,
 * checking current statuses, and sending batches for immediate or background processing.
 * This class provides an interface to efficiently handle batch-related operations.
 */
class ClockWiseManager implements ICWManager
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
     * Get the return of the processed batch
     * @param string $batchId
     * @return array
     * @throws BatchNotFoundException
     * @throws UnfinishedBatchException
     */
    public function getResults(string $batchId): array
    {
        $batchResult = $this->getBatchResultUseCase->execute($batchId);
        return $this->translator->translate($batchResult->toArray());
    }

    /**
     * Returns the current batch status
     * @param string $batchId
     * @return int
     * @throws BatchNotFoundException
     */
    public function getCurrentStatus(string $batchId): int
    {
        return $this->getCurrentBatchStatusUseCase->execute($batchId);
    }

    /**
     * Submit a batch for immediate processing
     * @param Batch $batch
     * @return array
     * @throws BatchSendFailedException
     */
    public function send(Batch $batch): array
    {
        $batchResult = $this->sendBatchUseCase->execute($batch);
        return $this->translator->translate($batchResult->toArray());
    }

    /**
     * Submit a batch for queue processing
     * @param Batch $batch
     * @return string
     * @throws BatchSendInBackgroundFailedException
     */
    public function sendInBackground(Batch $batch): string
    {
        return $this->sendBatchInBackgroundUseCase->execute($batch);
    }
}