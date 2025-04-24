<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use Shared\Domain\Exception\User\LastNameNotValidException;
use Shared\Domain\Model\User\LastName;
use Tests\TestCase;

class LastNameTest extends TestCase
{
    public function testValidLastNameFromString()
    {
        $name = $this->faker()->lastName;

        $lastName = LastName::fromString($name);
        static::assertEquals($name, $lastName->lastName());
    }

    /**
     * @dataProvider validLastNameDataProvider
     */
    public function testValidLastName($name)
    {
        $lastName = new LastName($name);
        static::assertEquals($name, $lastName->lastName());
    }

    public function validLastNameDataProvider()
    {
        return [
            ['S'],
            ['Some name'],
            [$this->faker()->lastName],
        ];
    }
    /**
     * @dataProvider invalidLastNameDataProvider
     */
    public function testInvalidLastName($name)
    {
        $this->expectException(LastNameNotValidException::class);

        new LastName($name);
    }

    public function invalidLastNameDataProvider()
    {
        return [
            [''],
            [$this->faker()->words(256, true)],
        ];
    }
}