<?php

namespace Tests\src;

use Faker\Generator;

class CwGenerator extends Generator
{
    public function documentNumber(): string
    {
        return $this->randomNumber();
    }
}