<?php

namespace Tests\SDK\Unit\Infrastructure\Service\Auth;

use App\SDK\Infrastructure\Service\Auth\AuthUserTransformer;
use Tests\SDK\Tools\Stub\User\Domain\UserStub;
use Tests\TestCase;

class AuthUserTransformerTest extends TestCase
{
    public function testTransformAuthUser()
    {
        $user = UserStub::random();
        $expected = [
            'id' => $user->userId()->userId()
        ];

        $sut = new AuthUserTransformer();
        static::assertSame($expected, $sut->transform($user));
    }
}
