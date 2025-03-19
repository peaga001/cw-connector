<?php

namespace Tests\Support;

use Faker\Generator;

trait CwGenerator
{
    protected Generator $faker;
    public function documentNumber(): string
    {
        return $this->faker->randomNumber();
    }
}