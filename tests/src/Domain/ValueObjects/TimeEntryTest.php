<?php

namespace Tests\src\Domain\ValueObjects;

use Domain\Exceptions\TimeEntry\InvalidDateException;
use Domain\Exceptions\TimeEntry\InvalidHoursException;
use Domain\ErrorCodes\DomainErrorCodes;
use Domain\ValueObjects\TimeEntry;
use Tests\Support\CwTestCase;
use DateTime;

class TimeEntryTest extends CwTestCase
{
    public function test_ShouldInstantiateTimeEntryFromDatetime(): void
    {
        $dateTime = $this->faker->dateTime();

        $timeEntry = new TimeEntry(
            date: $dateTime,
            hours: $dateTime
        );

        $this->assertInstanceOf(TimeEntry::class, $timeEntry);
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldInstantiateTimeEntryFromString(): void
    {
        $dateTime = $this->faker->dateTime();

        $timeEntry = TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $dateTime->format('H:i:s'),
        );

        $this->assertInstanceOf(TimeEntry::class, $timeEntry);
    }

    /**
     * @throws InvalidHoursException
     */
    public function test_ShouldThrowExceptionWhenDateIsInvalid(): void
    {
        $dateTime = $this->faker->dateTime();

        $this->expectException(InvalidDateException::class);
        $this->expectExceptionMessage('Date format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_DATE);

        TimeEntry::create(
            date: $dateTime->format('d/m/Y'),
            hours: $dateTime->format('H:i:s')
        );
    }

    /**
     * @throws InvalidHoursException
     * @throws InvalidDateException
     */
    public function test_ShouldThrowExceptionWhenHoursIsInvalid(): void
    {
        $dateTime = $this->faker->dateTime();

        $this->expectException(InvalidHoursException::class);
        $this->expectExceptionMessage('Hours format is invalid!');
        $this->expectExceptionCode(DomainErrorCodes::TIME_ENTRY_INVALID_HOURS);

        TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $dateTime->format('H:i')
        );
    }


    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_MustBeTrueWhenCompareToTheValues(): void
    {
        $dateTime = $this->faker->dateTime();
        $date = $dateTime->format('Y-m-d');
        $hours = $dateTime->format('H:i:s');

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
        $dateTime = $this->faker->dateTime();
        $hours = $dateTime->format('H:i:s');

        $timeEntry = TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $hours
        );

        $isEqual = $timeEntry->isEqual(
            date: $this->faker->dateTime()->format('Y-m-d'),
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
        $dateTime = $this->faker->dateTime();
        $date = $dateTime->format('Y-m-d');

        $timeEntry = TimeEntry::create(
            date: $date,
            hours: $dateTime->format('H:i:s')
        );

        $isEqual = $timeEntry->isEqual(
            date: $date,
            hours: $this->faker->dateTime()->format('H:i:s')
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

        $dateTime = $this->faker->dateTime();
        $hours = $dateTime->format('H:i:s');

        $timeEntry = TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $hours
        );

        $timeEntry->isEqual(
            date: $dateTime->format('d/m/Y'),
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

        $dateTime = $this->faker->dateTime();
        $date = $dateTime->format('Y-m-d');

        $timeEntry = TimeEntry::create(
            date: $date,
            hours: $dateTime->format('H:i:s')
        );

        $timeEntry->isEqual(
            date: $date,
            hours: $dateTime->format('H:i')
        );
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldReturnDate(): void
    {
        $dateTime = $this->faker->dateTime();
        $date = DateTime::createFromFormat('Y-m-d', $dateTime->format('Y-m-d'));

        $timeEntry = TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $dateTime->format('H:i:s')
        );

        $this->assertEquals($date->getTimestamp(), $timeEntry->date()->getTimestamp());
    }

    /**
     * @throws InvalidDateException
     * @throws InvalidHoursException
     */
    public function test_ShouldReturnHours(): void
    {
        $dateTime = $this->faker->dateTime();
        $hours = DateTime::createFromFormat('H:i:s', $dateTime->format('H:i:s'));

        $timeEntry = TimeEntry::create(
            date: $dateTime->format('Y-m-d'),
            hours: $dateTime->format('H:i:s')
        );

        $this->assertEquals($hours->getTimestamp(), $timeEntry->hours()->getTimestamp());
    }
}