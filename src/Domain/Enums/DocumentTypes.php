<?php

declare(strict_types=1);

namespace CwConnector\Domain\Enums;

/**
 * An enumeration representing types of documents.
 * Each case is associated with an integer value.
 */
enum DocumentTypes: int
{
    case EMPLOYEE_ID = 1;
    case CPF = 2;
}