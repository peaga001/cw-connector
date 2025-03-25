<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Infrastructure\Data\FromAPI;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//HTTPConfigs
use CwConnector\Infrastructure\Data\HTTP\Clients\Guzzle;
use CwConnector\Infrastructure\Data\HTTP\Clients\IClient;
use CwConnector\Infrastructure\Data\HTTP\Config\APIConfig;

//HTTPExceptions
use CwConnector\Infrastructure\Data\HTTP\Exceptions\HTTPErrorCodes;
use CwConnector\Infrastructure\Data\HTTP\Exceptions\UnauthorizedException;

//HTTPRepository
use CwConnector\Infrastructure\Data\HTTP\HTTPRepository;

//Entities
use CwConnector\Domain\Entities\Batch;

//GuzzleTools
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

//TestingTools
use PHPUnit\Framework\Attributes\DataProviderExternal;
use CwConnector\Tests\Support\Providers\HTTPRepositoryProvider;
use CwConnector\Tests\Support\CwTestCase;

class HTTPRepositoryWithGuzzleTest
    extends CwTestCase
{
    private IClient $guzzle;
    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzle = Guzzle::create(
            config: APIConfig::create(baseUrl: '', apiKey: '')
        );
    }

    /**
     * @throws DomainException
     */
    #[DataProviderExternal(HTTPRepositoryProvider::class, 'successRequests')]
    public function test_ShouldSendBatch(array $oauth, array $response): void
    {
        $handler = new MockHandler([
            new Response(status: 200, body: json_encode($oauth)),
            new Response(status: 201, body: json_encode($response))
        ]);

        $this->setHandler(handler: $handler);

        $repository = new HTTPRepository(client: $this->guzzle);
        $batch = $repository->sendBatch(batch: $this->batch());

        $this->assertInstanceOf(Batch::class, $batch);
        $this->assertEquals($response['batch_id'], $batch->batchId());
        $this->assertEquals($response['result'], $batch->result()->toArray());
    }

    /**
     * @throws DomainException
     */
    #[DataProviderExternal(HTTPRepositoryProvider::class, 'successRequests')]
    public function test_ShouldSendBatchInBackground(array $oauth, array $response): void
    {
        $handler = new MockHandler([
            new Response(status: 200, body: json_encode($oauth)),
            new Response(status: 201, body: json_encode($response))
        ]);

        $this->setHandler(handler: $handler);

        $repository = new HTTPRepository(client: $this->guzzle);
        $batch = $repository->sendBatchInBackground(batch: $this->batch());

        $this->assertInstanceOf(Batch::class, $batch);
        $this->assertEquals($response['batch_id'], $batch->batchId());
    }

    /**
     * @throws DomainException
     */
    #[DataProviderExternal(HTTPRepositoryProvider::class, 'successRequests')]
    public function test_ShouldGetById(array $oauth, array $response): void
    {
        $handler = new MockHandler([
            new Response(status: 200, body: json_encode($oauth)),
            new Response(status: 201, body: json_encode($response))
        ]);

        $this->setHandler(handler: $handler);

        $repository = new HTTPRepository(client: $this->guzzle);
        $batch = $repository->getById(id: $this->batchId());

        $this->assertInstanceOf(Batch::class, $batch);
        $this->assertEquals($response['batch_id'], $batch->batchId());
        $this->assertEquals($response['status'], $batch->status()->value);

    }

    /**
     * @throws DomainException
     */
    #[DataProviderExternal(HTTPRepositoryProvider::class, 'successRequests')]
    public function test_ShouldGetBatchResult(array $oauth, array $response): void
    {
        $handler = new MockHandler([
            new Response(status: 200, body: json_encode($oauth)),
            new Response(status: 201, body: json_encode($response))
        ]);

        $this->setHandler(handler: $handler);

        $repository = new HTTPRepository(client: $this->guzzle);
        $batch = $repository->getBatchResult(id: $this->batchId());

        $this->assertInstanceOf(Batch::class, $batch);
        $this->assertEquals($response['batch_id'], $batch->batchId());
        $this->assertEquals($response['result'], $batch->result()->toArray());
    }

    /**
     * @throws DomainException
     */
    public function test_ShouldThrowExceptionWhenTokenNotFound(): void
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized!');
        $this->expectExceptionCode(HTTPErrorCodes::UNAUTHORIZED);

        $handler = new MockHandler([
            new Response(status: 200, body: json_encode([]))
        ]);

        $this->setHandler(handler: $handler);

        $repository = new HTTPRepository(client: $this->guzzle);
        $repository->getById(id: $this->batchId());
    }

    private function setHandler(MockHandler $handler): void
    {
        $this->guzzle->client = new Client(['handler' => HandlerStack::create($handler)]);
    }
}