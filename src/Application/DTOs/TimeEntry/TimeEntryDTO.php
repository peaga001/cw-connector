<?php

declare(strict_types=1);

namespace CwConnector\Application\DTOs\TimeEntry;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ValueObjects
use CwConnector\Domain\ValueObjects\TimeEntry;

class TimeEntryDTO
{
    public function __construct(
        private readonly string $date,
        private readonly string $hours
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            date: $data['date'],
            hours: $data['hours']
        );
    }

    /**
     * @throws DomainException
     */
    public function toEntity(): TimeEntry
    {
        return TimeEntry::create(date: $this->date, hours: $this->hours);
    }
}