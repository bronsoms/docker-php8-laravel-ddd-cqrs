<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use App\SDK\Domain\Exception\User\FirstNameNotValidException;
use App\SDK\Domain\Model\User\FirstName;
use Tests\TestCase;

class FirstNameTest extends TestCase
{
    public function testValidFirstNameFromString()
    {
        $name = $this->faker()->lastName;

        $lastName = FirstName::fromString($name);
        static::assertEquals($name, $lastName->firstName());
    }

    /**
     * @dataProvider validFirstNameDataProvider
     */
    public function testValidFirstName($name)
    {
        $firstName = new FirstName($name);
        static::assertEquals($name, $firstName->firstName());
    }

    public function validFirstNameDataProvider()
    {
        return [
            ['S'],
            ['Some name'],
            [$this->faker()->firstName],
        ];
    }
    /**
     * @dataProvider invalidFirstNameDataProvider
     */
    public function testInvalidFirstName($name)
    {
        $this->expectException(FirstNameNotValidException::class);

        new FirstName($name);
    }

    public function invalidFirstNameDataProvider()
    {
        return [
            [''],
            [$this->faker()->words(256, true)],
        ];
    }
}