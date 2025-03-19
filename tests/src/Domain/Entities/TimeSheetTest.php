<?php

namespace Tests\src\Domain\Entities;

use Domain\Exceptions\TimeEntry\InvalidTimeEntriesException;
use Domain\Entities\TimeSheet;
use Domain\ErrorCodes\DomainErrorCodes;
use Tests\Support\CwTestCase;

class TimeSheetTest extends CwTestCase
{
    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldBeInstantiateTimeSheetFromConstructor(): void
    {
        $timeSheet = new TimeSheet(
            timeEntries: $this->timeEntries(),
            person: $this->personId()
        );

        $this->assertInstanceOf(TimeSheet::class, $timeSheet);
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldBeInstantiateTimeSheetFromStaticFunction(): void
    {
        $timeSheet = TimeSheet::create(
            timeEntries: $this->timeEntries(),
            person: $this->personId()
        );

        $this->assertInstanceOf(TimeSheet::class, $timeSheet);
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ThrowExceptionWhenTryInstantiateTimeSheetWithInvalidTimeEntries(): void
    {
        $this->expectException(InvalidTimeEntriesException::class);
        $this->expectExceptionMessage('Time entries is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_SHEET_INVALID_TIME_ENTRIES);

        $timeEntries = $this->timeEntries();
        $timeEntries[] = 'invalid time entry';
        $timeEntries[] = [$this->date(), $this->hours()];

        TimeSheet::create(
            timeEntries: $timeEntries,
            person: $this->personId()
        );
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldReturnTimeEntries(): void
    {
        $timeEntries = $this->timeEntries();

        $timeSheet = TimeSheet::create(
            timeEntries: $timeEntries,
            person: $this->personId()
        );

        $this->assertEquals($timeEntries, $timeSheet->timeEntries());
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldReturnPersonId(): void
    {
        $personId = $this->personId();

        $timeSheet = TimeSheet::create(
            timeEntries: $this->timeEntries(),
            person: $personId
        );

        $this->assertEquals($personId, $timeSheet->person());
    }
}