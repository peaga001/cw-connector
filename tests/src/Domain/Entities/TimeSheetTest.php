<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Domain\Entities;

//Entities
use CwConnector\Domain\Entities\TimeSheet;

//ErrorCodes
use CwConnector\Domain\ErrorCodes\DomainErrorCodes;

//Exceptions
use CwConnector\Domain\Exceptions\TimeEntry\InvalidTimeEntriesException;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;

class TimeSheetTest extends CwTestCase
{
    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldBeInstantiateTimeSheetFromConstructor(): void
    {
        $timeSheet = new TimeSheet(
            timeEntries: $this->timeEntries(),
            person: $this->personId(),
            config: $this->config()
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
            person: $this->personId(),
            config: $this->config()
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
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_TIME_ENTRIES);

        $timeEntries = $this->timeEntries();
        $timeEntries[] = 'invalid time entry';
        $timeEntries[] = [$this->date(), $this->hours()];

        TimeSheet::create(
            timeEntries: $timeEntries,
            person: $this->personId(),
            config: $this->config()
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
            person: $this->personId(),
            config: $this->config()
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
            person: $personId,
            config: $this->config()
        );

        $this->assertEquals($personId, $timeSheet->person());
    }

    /**
     * @throws InvalidTimeEntriesException
     */
    public function test_ShouldReturnTheValuesCorrectlyWhenCallingToArray(): void
    {
        $timeSheet = TimeSheet::create(
            timeEntries: $this->timeEntries(quantity: 1),
            person: $this->personId(),
            config: $this->config()
        );

        $this->assertEquals($timeSheet->person()->toArray(), $timeSheet->toArray()['person']);
        $this->assertEquals($timeSheet->timeEntries()[0]->toArray(), $timeSheet->toArray()['timeEntries'][0]);
        $this->assertEquals($timeSheet->config()->toArray(), $timeSheet->toArray()['config']);
    }
}