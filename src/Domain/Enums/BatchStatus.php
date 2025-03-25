<?php

declare(strict_types=1);

namespace CwConnector\Domain\Enums;

/**
 * Represents the status of a batch process with predefined states.
 */
enum BatchStatus: int
{
    case CREATED = 1;
    case SENT = 2;
    case FAILED = 3;
    case FINISHED = 4;
}
