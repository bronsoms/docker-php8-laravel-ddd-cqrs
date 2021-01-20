<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use App\SDK\Domain\Exception\User\PasswordNotValidException;
use App\SDK\Domain\Model\User\Password;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * @dataProvider validPasswords
     */
    public function testItShouldCreatePasswordWhenValid($password)
    {
        $actual = Password::fromString($password);

        static::assertInstanceOf(Password::class, $actual);
        static::assertEquals($password, $actual->password());
        static::assertEquals($password, $actual->__toString());
    }

    /**
     * @dataProvider invalidPasswords
     */
    public function testItShouldThrowExceptionWhenPasswordInvalid($password, $message)
    {
        $this->expectException(PasswordNotValidException::class);
        $this->expectExceptionMessage($message);

        Password::fromString($password);
    }

    /**
     * @dataProvider validPasswords
     */
    public function testItShouldHashPassword($password)
    {
        $actual = Password::fromString($password);

        static::assertNotEquals($password, $actual->hashed());
    }

    public function validPasswords()
    {
        return [
            ['edjk$fPSk2'],
            ['22jkf%PSk2'],
            ['ddjkfP@Sk2'],
            ['6^&nKP^A^'],
        ];
    }

    public function invalidPasswords()
    {
        return [
            ['123456789', 'The password should have at least 1 uppercase letter'],
            ['kjdfKjhsd', 'The password should have at least 1 number'],
            ['kFj3"d', 'The password should have at least 8 characters'],
            ['kjdDdddd(', 'The password should have at least 1 number'],
            ['kjddddDd@', 'The password should have at least 1 number'],
            ['k1dd$dD', 'The password should have at least 8 characters'],
            ['6nKPA', 'The password should have at least 1 special character'],
            ['DDJKFPSK2', 'The password should have at least 1 lowercase letter'],
            ['ddjkfp2k2', 'The password should have at least 1 uppercase letter'],
        ];
    }
}
