<?php

declare(strict_types=1);

namespace App\Application\DTOs;

class BatchCurrentStatusDTO
{
    public function __construct(
        public int $currentStatus,
        public array $errors
    ){}

    public function toArray(): array
    {
        return [
            'currentStatus' => $this->currentStatus,
            'errors'  => $this->errors
        ];
    }
}