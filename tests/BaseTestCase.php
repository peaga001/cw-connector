<?php

declare(strict_types=1);

namespace Tests;

use App\Domain\Entities\Cart;
use App\Domain\Entities\Product;
use App\Domain\Entities\User;
use Faker\Factory;
use Faker\Generator;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    protected function createUserMock(
        ?string $userName = null,
        ?string $zipCode = null
    )
    {
        $userName = $userName ?? $this->faker->name();
        $zipCode = $zipCode ?? str_pad((string) $this->faker->randomNumber(nbDigits: 8), 8, '0');

        return Mockery::mock(User::class, [$userName, $zipCode]);
    }

    protected function createProductMock(
        ?string $productName = null,
        ?float $productPrice = null
    )
    {
        $productName = $productName ?? $this->faker->name();
        $productPrice = $productPrice ?? $this->faker->randomFloat(nbMaxDecimals: 2, min: 0.01, max: 99999.99);

        return Mockery::mock(Product::class,[$productName, $productPrice]);
    }

    protected function createProductsMock(int $quantity = 1): array
    {
        return array_map(fn() => [
            'product' => $this->createProductMock(),
            'quantity' => $this->faker->numberBetween(1, 100)
        ], range(1, $quantity));
    }

    protected function createCartMock(
        ?MockInterface $user = null,
        ?array $products = null
    )
    {
        $user = $user ?? $this->createUserMock();

        $cartMock = Mockery::mock(Cart::class,[$user]);

        $products && $cartMock->shouldReceive('addProducts')->with($products);

        return $cartMock;
    }

    protected function makeZipCode(): string
    {
        return str_pad((string) $this->faker->randomNumber(nbDigits: 8), 8, '0');
    }
}