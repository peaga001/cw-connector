<?php

namespace Tests\Support\Providers;

use Domain\Enums\BatchStatus;

final class BatchStatusProvider
{
    public static function all(): array
    {
        return [
            'Created' => [BatchStatus::CREATED],
            'Sent' => [BatchStatus::SENT],
            'Failed' => [BatchStatus::FAILED],
            'Finished' => [BatchStatus::FINISHED]
        ];
    }
}