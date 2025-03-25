<?php

declare(strict_types=1);

namespace CwConnector\Domain\Entities;

//ValueObjects
use CwConnector\Domain\ValueObjects\TimeEntry;
use CwConnector\Domain\ValueObjects\PersonId;

//Exceptions
use CwConnector\Domain\Exceptions\TimeEntry\InvalidTimeEntriesException;

class TimeSheet
{
    /**
     * @param TimeEntry[] $timeEntries
     * @throws InvalidTimeEntriesException
     */
    public function __construct(
        private readonly array $timeEntries,
        private readonly PersonId $person,
        private readonly Config $config
    ){
        $this->checkTimeEntries();
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public static function create(
        array $timeEntries,
        PersonId $person,
        Config $config
    ): self
    {
        return new self(
            timeEntries: $timeEntries, person: $person, config: $config
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

    public function config(): Config
    {
        return $this->config;
    }

    public function toArray(): array
    {
        $timeEntries = [];

        foreach ($this->timeEntries as $timeEntry){
            $timeEntries[] = $timeEntry->toArray();
        }

        return [
            'person' => $this->person->toArray(),
            'config' => $this->config->toArray(),
            'timeEntries' => $timeEntries
        ];
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