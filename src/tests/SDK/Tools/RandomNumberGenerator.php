<?php

namespace Tests\SDK\Tools;

use Faker\Factory;
use Faker\Generator;

class RandomNumberGenerator
{
    private const INTEGER_MIN = 1;

    /** @var \Faker\Generator */
    private $faker;

    public static function integer($max = 2147483647): int
    {
        return (new self())->uniqueInteger($max);
    }

    public static function float(float $max = null, int $maxDecimals = 4): float
    {
        $faker = Factory::create();

        $min = bcpow(10, ($maxDecimals * -1));

        return number_format($faker->randomFloat($maxDecimals, $min, $max), 4, '.', '');
    }

    public static function negativeFloat(float $min = null, int $maxDecimals = 4): float
    {
        $faker = Factory::create();

        $min = (null === $min ? null : bcmul($min, -1));
        $max = bcpow(10, ($maxDecimals * -1));

        return number_format(bcmul($faker->randomFloat($maxDecimals, $max, $min), -1), 4, '.', '');
    }

    public function __construct(Generator $generator = null)
    {
        $this->faker = $generator ?? Factory::create();
    }

    public function uniqueInteger(int $max = 2147483647): int
    {
        return $this->faker->unique()->numberBetween(self::INTEGER_MIN, $max);
    }
}
