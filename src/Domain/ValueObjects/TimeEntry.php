<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use App\Domain\Exceptions\TimeEntry\InvalidDateException;
use App\Domain\Exceptions\TimeEntry\InvalidHoursException;
use DateTime;

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

    public function date(): DateTime
    {
        return $this->date;
    }

    public function hours(): DateTime
    {
        return $this->hours;
    }
}