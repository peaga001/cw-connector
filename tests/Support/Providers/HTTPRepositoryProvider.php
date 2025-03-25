<?php

namespace CwConnector\Tests\Support\Providers;

final class HTTPRepositoryProvider
{
    public static function successRequests(): array
    {
        return [
            'From Http With Guzzle' => [
                ['token' => 'oauth_token'],
                [
                    'batch_id'    => '1234567',
                    'status'      => 4,
                    'time_sheets' => [
                        [
                            'person' => ['document_type'   => 1,'document_number' => '123456789'],
                            'time_entries' => [
                                ['date' => '2024-01-01', 'hours' => '12:00:00'],
                                ['date' => '2024-01-01', 'hours' => '12:00:00']
                            ],
                            'config' => [
                                'is_flexible' => true,
                                'coffee_break' => 1,
                                'day_type' => 'workday'
                            ]
                        ],
                        [
                            'person' => ['document_type'   => 1,'document_number' => '123456789'],
                            'time_entries' => [
                                ['date' => '2024-01-01', 'hours' => '12:00:00'],
                                ['date' => '2024-01-01', 'hours' => '12:00:00']
                            ],
                            'config' => [
                                'is_flexible' => true,
                                'coffee_break' => 1,
                                'day_type' => 'workday'
                            ]
                        ]
                    ],
                    'result' => ['success' => true, 'message' => 'Batch created successfully']
                ]
            ]
        ];
    }
}