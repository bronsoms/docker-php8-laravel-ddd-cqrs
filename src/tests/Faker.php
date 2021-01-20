<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Tests\SDK\Tools\RandomNumberGenerator;

trait Faker
{
    /** @var Generator */
    private $faker;

    /** @var RandomNumberGenerator */
    private $randomNumberGenerator;

    final protected function faker(): Generator
    {
        if (null === $this->faker) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    final protected function randomNumberGenerator(): RandomNumberGenerator
    {
        if (null === $this->randomNumberGenerator) {
            $this->randomNumberGenerator = new RandomNumberGenerator($this->faker());
        }

        return $this->randomNumberGenerator;
    }
}
