<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\Exceptions\TimeEntry\InvalidTimeEntriesException;
use Domain\ValueObjects\PersonId;
use Domain\ValueObjects\TimeEntry;

class TimeSheet
{
    /**
     * @param TimeEntry[] $timeEntries
     * @throws InvalidTimeEntriesException
     */
    public function __construct(
        private readonly array $timeEntries,
        private readonly PersonId $person
    ){
        $this->checkTimeEntries();
    }

    /**
     * @throws InvalidTimeEntriesException
     */
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

    /**
     * @throws InvalidTimeEntriesException
     */
    private function checkTimeEntries(): void
    {
        foreach ($this->timeEntries as $timeEntry){
            $isTimeSheet = $timeEntry instanceof TimeEntry;

            if(!$isTimeSheet){
                throw new InvalidTimeEntriesException;
            }
        }
    }
}