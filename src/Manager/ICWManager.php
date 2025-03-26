<?php

declare(strict_types=1);

namespace CwConnector\Manager;

//Entities
use CwConnector\Domain\Entities\Batch;

//Exceptions
use CwConnector\Domain\Exceptions\Batch\BatchNotFoundException;
use CwConnector\Domain\Exceptions\Batch\BatchSendFailedException;
use CwConnector\Domain\Exceptions\Batch\BatchSendInBackgroundFailedException;
use CwConnector\Domain\Exceptions\Batch\UnfinishedBatchException;

interface ICWManager
{
    /**
     * Get the return of the processed batch
     * @param string $batchId
     * @return array
     * @throws BatchNotFoundException
     * @throws UnfinishedBatchException
     */
    public function getResults(string $batchId): array;

    /**
     * Returns the current batch status
     * @param string $batchId
     * @return int
     * @throws BatchNotFoundException
     */
    public function getCurrentStatus(string $batchId): int;

    /**
     * Submit a batch for immediate processing
     * @param Batch $batch
     * @return array
     * @throws BatchSendFailedException
     */
    public function send(Batch $batch): array;

    /**
     * Submit a batch for queue processing
     * @param Batch $batch
     * @return string
     * @throws BatchSendInBackgroundFailedException
     */
    public function sendInBackground(Batch $batch): string;
}