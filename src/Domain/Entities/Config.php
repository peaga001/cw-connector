<?php

declare(strict_types=1);

namespace CwConnector\Domain\Entities;

//ValueObjects
use CwConnector\Domain\ValueObjects\Property;

/**
 * Represents a batch configuration which contains a collection of properties.
 * Provides methods to add, retrieve, and check for properties, as well as convert them to an array format.
 */
class Config
{
    /**
     * @param Property[] $properties
     */
    public function __construct(
        private array $properties = []
    ){}

    /**
     * @param array $properties
     * @return self
     */
    public static function fill(array $properties): self
    {
        $config = new self();

        foreach ($properties as $key => $property){
            $config->set(key: $key, value: $property);
        }

        return $config;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    /**
     * @param string $key
     * @return ?Property
     */
    public function get(string $key): ?Property
    {
        if(!$this->has($key)) {
            return null;
        }

        return $this->properties[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->properties[] = Property::create(key: $key, value: $value);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $properties = [];

        foreach ($this->properties as $property){
            $properties[$property->getKey()] = $property->getValue();
        }

        return $properties;
    }
}