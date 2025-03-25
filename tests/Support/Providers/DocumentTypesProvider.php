<?php

namespace CwConnector\Tests\Support\Providers;

use CwConnector\Domain\Enums\DocumentTypes;

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