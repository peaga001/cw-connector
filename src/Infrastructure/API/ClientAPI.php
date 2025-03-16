<?php

declare(strict_types=1);

namespace App\Infrastructure\API;

use App\Infrastructure\API\Config\APIConfig;
use App\Infrastructure\API\Config\IClientAPI;

class ClientAPI implements IClientAPI
{

    public function create(APIConfig $config): IClientAPI
    {
        // TODO: Implement create() method.
    }
}