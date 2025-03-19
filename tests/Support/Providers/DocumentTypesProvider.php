<?php

namespace Tests\Support\Providers;

use Domain\Enums\DocumentTypes;

final class DocumentTypesProvider
{
    public static function all(): array
    {
        return [
            'employee_id' => [DocumentTypes::EMPLOYEE_ID],
            'cpf' => [DocumentTypes::CPF]
        ];
    }
}