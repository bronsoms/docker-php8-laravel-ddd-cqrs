<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use Shared\Domain\Exception\User\UsernameNotValidException;
use Shared\Domain\Model\User\Username;
use Tests\TestCase;

class UsernameTest extends TestCase
{
    public function testValidUsernameFromString()
    {
        $name = $this->faker()->userName;

        $username = Username::fromString($name);
        static::assertEquals($name, $username->username());
    }

    /**
     * @dataProvider validUsernameDataProvider
     */
    public function testValidUsername($name)
    {
        $username = new Username($name);
        static::assertEquals($name, $username->username());
    }

    public function validUsernameDataProvider()
    {
        return [
            ['Sfedg'],
            ['someusername'],
            [$this->faker()->username],
        ];
    }
    /**
     * @dataProvider invalidUsernameDataProvider
     */
    public function testInvalidUsername($name)
    {
        $this->expectException(UsernameNotValidException::class);

        new Username($name);
    }

    public function invalidUsernameDataProvider()
    {
        return [
            [''],
            ['S'],
            [$this->faker()->words(256, true)],
            ['foo bar']
        ];
    }
}