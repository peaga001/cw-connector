<?php

declare(strict_types=1);

namespace Application\Ports;

interface ITranslator
{
    public static function translate(array $result): array;
}