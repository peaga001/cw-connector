<?php

namespace Tests\src\Domain\ValueObjects;

use Domain\Exceptions\TimeEntry\InvalidDateException;
use Domain\Exceptions\TimeEntry\InvalidHoursException;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\ValueObjects\TimeEntry;
use Tests\Support\CwTestCase;

class TimeEntryTest extends CwTestCase
{
    public function test_ShouldInstantiateTimeEntryFromDatetime(): void
    {
        $timeEntry = new TimeEntry(
            date: $this->date(),
            hours: $this->hours()
        );

        $this->assertInstanceOf(TimeEntry::class, $timeEntry);
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldInstantiateTimeEntryFromString(): void
    {
        $timeEntry = TimeEntry::create(
            date: $this->date()->format('Y-m-d'),
            hours: $this->hours()->format('H:i:s'),
        );

        $this->assertInstanceOf(TimeEntry::class, $timeEntry);
    }

    /**
     * @throws InvalidHoursException
     */
    public function test_ShouldThrowExceptionWhenDateIsInvalid(): void
    {
        $this->expectException(InvalidDateException::class);
        $this->expectExceptionMessage('Date format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_DATE);

        TimeEntry::create(
            date: $this->date()->format('d/m/Y'),
            hours: $this->hours()->format('H:i:s')
        );
    }

    /**
     * @throws InvalidHoursException
     * @throws InvalidDateException
     */
    public function test_ShouldThrowExceptionWhenHoursIsInvalid(): void
    {
        $this->expectException(InvalidHoursException::class);
        $this->expectExceptionMessage('Hours format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_HOURS);

        TimeEntry::create(
            date: $this->date()->format('Y-m-d'),
            hours: $this->hours()->format('H:i')
        );
    }


    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_MustBeTrueWhenCompareToTheValues(): void
    {
        $date = $this->date()->format('Y-m-d');
        $hours = $this->hours()->format('H:i:s');

        $timeEntry = TimeEntry::create(
            date: $date,
            hours: $hours,
        );

        $isEqual = $timeEntry->isEqual(
            date: $date,
            hours: $hours
        );

        $this->assertTrue($isEqual);
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_MustBeFalseWhenCompareToDifferentDates(): void
    {
        $hours = $this->hours()->format('H:i:s');

        $timeEntry = TimeEntry::create(
            date: $this->date()->format('Y-m-d'),
            hours: $hours
        );

        $isEqual = $timeEntry->isEqual(
            date: $this->date()->format('Y-m-d'),
            hours: $hours
        );

        $this->assertFalse($isEqual);
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_MustBeFalseWhenCompareToDifferentHours(): void
    {
        $date = $this->date()->format('Y-m-d');

        $timeEntry = TimeEntry::create(
            date: $date,
            hours: $this->hours()->format('H:i:s')
        );

        $isEqual = $timeEntry->isEqual(
            date: $date,
            hours: $this->hours()->format('H:i:s')
        );

        $this->assertFalse($isEqual);
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldThrowExceptionWhenComparingInvalidDates(): void
    {
        $this->expectException(InvalidDateException::class);
        $this->expectExceptionMessage('Date format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_DATE);

        $date = $this->date();
        $hours = $this->hours()->format('H:i:s');

        $timeEntry = TimeEntry::create(
            date: $date->format('Y-m-d'),
            hours: $hours
        );

        $timeEntry->isEqual(
            date: $date->format('d/m/Y'),
            hours: $hours
        );
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldThrowExceptionWhenComparingInvalidHours(): void
    {
        $this->expectException(InvalidHoursException::class);
        $this->expectExceptionMessage('Hours format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_HOURS);

        $date = $this->date()->format('Y-m-d');
        $hours = $this->hours();

        $timeEntry = TimeEntry::create(
            date: $date,
            hours: $hours->format('H:i:s')
        );

        $timeEntry->isEqual(
            date: $date,
            hours: $hours->format('H:i')
        );
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldReturnDate(): void
    {
        $date = $this->date();

        $timeEntry = TimeEntry::create(
            date: $date->format('Y-m-d'),
            hours: $this->hours()->format('H:i:s')
        );

        $this->assertEquals($date->getTimestamp(), $timeEntry->date()->getTimestamp());
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldReturnHours(): void
    {
        $hours = $this->hours();

        $timeEntry = TimeEntry::create(
            date: $this->date()->format('Y-m-d'),
            hours: $hours->format('H:i:s')
        );

        $this->assertEquals($hours->getTimestamp(), $timeEntry->hours()->getTimestamp());
    }
}