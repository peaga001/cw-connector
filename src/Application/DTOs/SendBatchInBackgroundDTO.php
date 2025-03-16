<?php

declare(strict_types=1);

namespace App\Application\DTOs;

class SendBatchInBackgroundDTO
{
    public function __construct(
        public string $batchId,
        public array $errors
    ){}

    public function toArray(): array
    {
        return [
            'batchId' => $this->batchId,
            'errors'  => $this->errors
        ];
    }
}