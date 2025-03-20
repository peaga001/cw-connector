<?php

declare(strict_types=1);

namespace Application\DTOs;

class BatchCurrentStatusDTO
{
    public function __construct(
        public int $currentStatus
    ){}

    public function toArray(): array
    {
        return [
            'currentStatus' => $this->currentStatus
        ];
    }
}