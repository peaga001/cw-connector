<?php

declare(strict_types=1);

namespace Application\DTOs;

class SendBatchInBackgroundDTO
{
    public function __construct(
        public string $batchId
    ){}

    public function toArray(): array
    {
        return [
            'batchId' => $this->batchId
        ];
    }
}