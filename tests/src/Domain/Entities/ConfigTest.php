<?php

declare(strict_types=1);

namespace CwConnector\Tests\src\Domain\Entities;

//Entities
use CwConnector\Domain\Entities\Config;

//TestingTools
use CwConnector\Tests\Support\CwTestCase;

class ConfigTest extends CwTestCase
{
    public function test_ShouldBeInstantiateConfigFromConstructor(): void
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config);
    }

    public function test_ShouldBeInstantiateConfigFromStaticClass(): void
    {
        $config = Config::fill([]);
        $this->assertInstanceOf(Config::class, $config);
    }

    public function test_ShouldBeReturnTheValueCorrectlyWhenCallingGet(): void
    {
        $config = Config::fill([
            'property_key' => 'property_value'
        ]);

        $property = $config->get('property_key');

        $this->assertEquals('property_key', $property->getKey());
        $this->assertEquals('property_value', $property->getValue());
    }

    public function test_ShouldBeReturnNullWhenCallingGetWithNonExistingKey(): void
    {
        $config = Config::fill([]);
        $property = $config->get('property_key');

        $this->assertNull($property);
    }
}