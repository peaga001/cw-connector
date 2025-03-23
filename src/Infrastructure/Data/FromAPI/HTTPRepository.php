<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\FromAPI;

use App\Application\DTOs\Batch\BatchDTO;
use App\Domain\Exceptions\DomainException;
use App\Infrastructure\Data\FromAPI\Config\IClient;
use App\Infrastructure\Data\FromAPI\Config\Routes;
use Domain\Entities\Batch;
use Domain\Ports\IRepository;

class HTTPRepository implements IRepository
{
    public function __construct(
        private readonly IClient $client
    ){}

    /**
     * @throws DomainException
     */
    public function getBatchResult(string $id): ?Batch
    {
        $return = $this->client->get(
            uri: Routes::GET_RESULT . "/{$id}"
        );

        return BatchDTO::fromArray($return)->toEntity();
    }

    /**
     * @throws DomainException
     */
    public function getById(string $id): ?Batch
    {
        $result = $this->client->get(
            uri: Routes::FIND . "/{$id}"
        );

        return BatchDTO::fromArray($result)->toEntity();
    }

    /**
     * @throws DomainException
     */
    public function sendBatch(Batch $batch): ?Batch
    {
        $result = $this->client->post(
            uri: Routes::SEND,
            body: [
                'timeSheets' => $batch->timeSheets()
            ]
        );

        return BatchDTO::fromArray($result)->toEntity();
    }

    /**
     * @throws DomainException
     */
    public function sendBatchInBackground(Batch $batch): ?Batch
    {
        $result = $this->client->post(
            uri: Routes::SEND_IN_BACKGROUND,
            body: [
                'timeSheets' => $batch->timeSheets()
            ]
        );

        return BatchDTO::fromArray($result)->toEntity();
    }
}