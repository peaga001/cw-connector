<?php

namespace App\Application\DTOs\TimeEntry;

use App\Domain\Exceptions\DomainException;
use Domain\ValueObjects\TimeEntry;

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