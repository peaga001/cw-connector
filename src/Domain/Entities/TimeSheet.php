<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\PersonId;
use Domain\ValueObjects\TimeEntry;

class TimeSheet
{
    /**
     * @param TimeEntry[] $timeEntries
     */
    public function __construct(
        private readonly array $timeEntries,
        private readonly PersonId $person
    ){}

    public static function create(array $timeEntries, PersonId $person): self
    {
        return new self(
            timeEntries: $timeEntries, person: $person
        );
    }

    public function person(): PersonId
    {
        return $this->person;
    }

    public function timeEntries(): array
    {
        return $this->timeEntries;
    }
}