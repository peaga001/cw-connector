<?php

declare(strict_types=1);

namespace CwConnector\Application\DTOs\TimeSheet;

//DTOs
use CwConnector\Application\DTOs\TimeEntry\TimeEntryDTO;

//Entities
use CwConnector\Domain\Entities\TimeSheet;
use CwConnector\Domain\Entities\Config;

//Exceptions
use CwConnector\Domain\Exceptions\DomainException;

//ValueObjects
use CwConnector\Domain\ValueObjects\PersonId;

class TimeSheetDTO
{
    public function __construct(
        private readonly PersonId $personId,
        private readonly array $timeEntries = [],
        private readonly ?Config $config = null,
    ){}

    /**
     * @throws DomainException
     */
    public static function fromArray(array $data): self
    {
        $config = Config::fill($data['config']);
        $timeEntries = [];
        $personId = PersonId::create(
            documentType: $data['person']['document_type'],
            documentNumber: $data['person']['document_number']
        );

        foreach ($data['time_entries'] as $timeEntry) {
            $timeEntries[] = TimeEntryDTO::fromArray($timeEntry)->toEntity();
        }

        return new self(
            personId: $personId,
            timeEntries: $timeEntries,
            config: $config
        );
    }

    /**
     * @throws DomainException
     */
    public function toEntity(): TimeSheet
    {
        return TimeSheet::create(
            timeEntries: $this->timeEntries,
            person: $this->personId,
            config: $this->config
        );
    }
}