<?php

declare(strict_types=1);

namespace CwConnector\Domain\Enums;

enum BatchStatus: int
{
    case CREATED = 1;
    case SENT = 2;
    case FAILED = 3;
    case FINISHED = 4;
}
