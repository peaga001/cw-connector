<?php

declare(strict_types=1);

namespace App\Infrastructure\API\Config;

interface IClientAPI
{
    public function create(APIConfig $config): self;
}