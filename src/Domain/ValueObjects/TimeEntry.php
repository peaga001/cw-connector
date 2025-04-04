<?php

declare(strict_types=1);

namespace CwConnector\Domain\ValueObjects;

//Exceptions
use CwConnector\Domain\Exceptions\TimeEntry\InvalidDateException;
use CwConnector\Domain\Exceptions\TimeEntry\InvalidHoursException;

//TestingTools
use DateTime;

/**
 * Represents a time entry with a specific date and hours.
 *
 * Provides methods to create, compare, and retrieve time entry data.
 */
class TimeEntry
{
    public function __construct(
        private readonly DateTime $date,
        private readonly DateTime $hours
    ){}

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public static function create(string $date, string $hours): self
    {
        $date = DateTime::createFromFormat('Y-m-d', $date);

        if(!$date){
            throw new InvalidDateException;
        }

        $hours = DateTime::createFromFormat('H:i:s', $hours);

        if(!$hours){
            throw new InvalidHoursException;
        }

        return new self(
            date: $date, hours: $hours
        );
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function isEqual(string $date, string $hours): bool
    {
        $date = DateTime::createFromFormat('Y-m-d', $date);

        if(!$date){
            throw new InvalidDateException;
        }

        $hours = DateTime::createFromFormat('H:i:s', $hours);

        if(!$hours){
            throw new InvalidHoursException;
        }


        return $this->hours->getTimestamp() === $hours->getTimestamp() &&
            $this->date->getTimestamp() === $date->getTimestamp();
    }

    public function date(): DateTime
    {
        return $this->date;
    }

    public function hours(): DateTime
    {
        return $this->hours;
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'hours' => $this->hours->format('H:i:s')
        ];
    }
}