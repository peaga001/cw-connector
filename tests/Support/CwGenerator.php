<?php

namespace Tests\Support;

use DateTime;
use Domain\Entities\Batch;
use Domain\Entities\TimeSheet;
use Domain\Enums\DocumentTypes;
use Domain\ValueObjects\BatchResult\BatchResult;
use Domain\ValueObjects\PersonId;
use Domain\ValueObjects\TimeEntry;
use Faker\Generator;
use Mockery;

trait CwGenerator
{
    protected Generator $faker;
    public function documentNumber(): string
    {
        return $this->faker->randomNumber();
    }

    public function documentType(): DocumentTypes
    {
        return $this->faker->randomElement(DocumentTypes::cases());
    }

    public function timeEntries(int $quantity = 4): array
    {
        $timeEntries = [];

        for ($index = 0; $index < $quantity; $index++) {
            $timeEntries[] = Mockery::mock(TimeEntry::class, [$this->date(), $this->hours()]);
        }

        return $timeEntries;
    }

    public function timeSheets(int $quantity = 30, $entriesPerTimeSheet = 4): array
    {
        $timeSheets = [];

        for ($index = 0; $index < $quantity; $index++) {
            $timeSheets[] = Mockery::mock(TimeSheet::class, [
                $this->timeEntries($entriesPerTimeSheet),
                $this->personId()
            ]);
        }

        return $timeSheets;
    }

    public function personId(): PersonId
    {
        return Mockery::mock(PersonId::class, [$this->documentType(), $this->documentNumber()]);
    }

    public function date(): DateTime
    {
        $date = $this->faker->dateTime()->format('Y-m-d');
        return DateTime::createFromFormat('Y-m-d', $date);
    }

    public function hours(): DateTime
    {
        $hours = $this->faker->dateTime()->format('H:i:s');
        return DateTime::createFromFormat('H:i:s', $hours);
    }

    public function batch($withId = false, $withResult = false): Batch
    {
        $batch = Mockery::mock(Batch::class, [$this->timeSheets()]);
        $makePartial = $withId || $withResult;

        if($makePartial){
            $batch->makePartial();
        }

        if($withId){
            $batch->setBatchId($this->batchId());
        }

        if($withResult){
            $batch->setResult($this->batchResult());
        }

        return $batch;
    }

    public function batchId(): string
    {
        $sha = $this->faker->sha256();
        return substr($sha, 0, 8);
    }

    public function batchResult(): BatchResult
    {
        return Mockery::mock(BatchResult::class, [[]]);
    }
}