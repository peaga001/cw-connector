<?php

declare(strict_types=1);

namespace CwConnector\Domain\Enums;

enum DocumentTypes: int
{
    case EMPLOYEE_ID = 1;
    case CPF = 2;
}