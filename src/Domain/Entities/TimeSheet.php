<?php

declare(strict_types=1);

namespace CwConnector\Domain\Entities;

//ValueObjects
use CwConnector\Domain\ValueObjects\TimeEntry;
use CwConnector\Domain\ValueObjects\PersonId;

//Exceptions
use CwConnector\Domain\Exceptions\TimeEntry\InvalidTimeEntriesException;

/**
 * Represents a time sheet which handles a collection of time entries,
 * associated with a specific person and configuration.
 */
class TimeSheet
{
    /**
     * @param TimeSheet[] $timeEntries
     * @param PersonId $person
     * @param Config $config
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
     * @param TimeSheet[] $timeEntries
     * @param PersonId $person
     * @param Config $config
     * @return self
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

    /**
     * @return PersonId
     */
    public function person(): PersonId
    {
        return $this->person;
    }

    /**
     * @return TimeSheet[]
     */
    public function timeEntries(): array
    {
        return $this->timeEntries;
    }

    /**
     * @return Config
     */
    public function config(): Config
    {
        return $this->config;
    }

    /**
     * @return array
     */
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
     * @return void
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