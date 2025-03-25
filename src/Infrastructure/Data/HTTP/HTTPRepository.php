<?php

declare(strict_types=1);

namespace Infrastructure\Data\HTTP;

//DTOs
use Application\DTOs\Batch\BatchDTO;

//Exceptions
use Domain\Exceptions\DomainException;

//HTTPConfigs
use Infrastructure\Data\HTTP\Clients\IClient;
use Infrastructure\Data\HTTP\Config\Routes;

//Entities
use Domain\Entities\Batch;

//Ports
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
            body: $batch->toArray()
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