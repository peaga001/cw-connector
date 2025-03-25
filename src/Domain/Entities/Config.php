<?php

declare(strict_types=1);

namespace CwConnector\Domain\Entities;

//ValueObjects
use CwConnector\Domain\ValueObjects\Property;

class Config
{
    /**
     * @param Property[] $properties
     */
    public function __construct(
        private array $properties = []
    ){}

    public static function fill(array $properties): self
    {
        $config = new self();

        foreach ($properties as $key => $property){
            $config->set(key: $key, value: $property);
        }

        return $config;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    public function get(string $key): ?Property
    {
        if(!$this->has($key)) {
            return null;
        }

        return $this->properties[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $this->properties[] = Property::create(key: $key, value: $value);
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->properties as $property){
            $properties[] = $property->toArray();
        }

        return $properties;
    }
}