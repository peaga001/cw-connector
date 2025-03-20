<?php

declare(strict_types=1);

namespace Application\DTOs;

class BatchResultDTO
{
    public function __construct(
        public array $result
    ){}

    public function toArray(): array
    {
        return [
            'result' => $this->result
        ];
    }
}