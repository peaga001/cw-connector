<?php

namespace App\Application\DTOs\TimeSheet;

use App\Application\DTOs\TimeEntry\TimeEntryDTO;
use App\Domain\Exceptions\DomainException;
use Domain\Entities\TimeSheet;
use Domain\ValueObjects\PersonId;

class TimeSheetDTO
{
    public function __construct(
        private readonly PersonId $personId,
        private readonly array $timeEntries = []
    ){}

    /**
     * @throws DomainException
     */
    public static function fromArray(array $data): self
    {
        $timeEntries = [];
        $personId = PersonId::create(documentType: $data['documentType'], documentNumber: $data['documentNumber']);

        foreach ($data['timeEntries'] as $timeEntry) {
            $timeEntries[] = TimeEntryDTO::fromArray($timeEntry)->toEntity();
        }

        return new self(
            personId: $personId,
            timeEntries: $timeEntries
        );
    }

    /**
     * @throws DomainException
     */
    public function toEntity(): TimeSheet
    {
        return TimeSheet::create(
            timeEntries: $this->timeEntries,
            person: $this->personId
        );
    }
}