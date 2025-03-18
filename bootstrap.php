<?php

use DI\Container;
use App\Contracts\HttpClientInterface;
use App\Services\GuzzleHttpClientService;
use GuzzleHttp\Client;

require_once 'vendor/autoload.php';

$container = new Container();

// Mapeando a interface para a implementação concreta
$container->set(HttpClientInterface::class, function ($c) {
    return new GuzzleHttpClientService($c->get(Client::class));
});

return $container;
