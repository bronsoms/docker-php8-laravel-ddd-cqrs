<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging\Broadway\Service;

use Shared\Infrastructure\Messaging\Broadway\Service\DomainMessageMetadataEnricher;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use Illuminate\Contracts\Auth\Guard;
use Shared\Domain\Model\User\User;
use Illuminate\Auth\AuthManager;
use Broadway\Domain\Metadata;
use Tests\TestCase;

class DomainMessageMetadataEnricherTest extends TestCase
{
    public function testShouldEnrichMetadataWithUserAsAuthor()
    {
        $userId = UserIdStub::random();
        $metadataIn = new Metadata();
        $metadataOut = new Metadata(['author_id' => $userId->userId()]);

        $authManager = $this->prophesize(AuthManager::class);
        $guard = $this->prophesize(Guard::class);
        $user = $this->prophesize(User::class);

        $authManager->guard()->shouldBeCalledOnce()->willReturn($guard);
        $guard->user()->shouldBeCalledOnce()->willReturn($user);
        $user->getAggregateRootId()->shouldBeCalledOnce()->willReturn($userId);

        $sut = new DomainMessageMetadataEnricher($authManager->reveal());
        $result = $sut->enrich($metadataIn);

        static::assertEquals($metadataOut, $result);
    }

    public function testShouldEnrichMetadataWithDefaultAuthor()
    {
        $metadataIn = new Metadata();
        $metadataOut = new Metadata(['author_id' => DomainMessageMetadataEnricher::DEFAULT_AUTHOR]);

        $authManager = $this->prophesize(AuthManager::class);
        $guard = $this->prophesize(Guard::class);
        $user = $this->prophesize(User::class);

        $authManager->guard()->shouldBeCalledOnce()->willReturn($guard);
        $guard->user()->shouldBeCalledOnce()->willReturn(null);
        $user->getAggregateRootId()->shouldNotBeCalled();

        $sut = new DomainMessageMetadataEnricher($authManager->reveal());
        $result = $sut->enrich($metadataIn);

        static::assertEquals($metadataOut, $result);
    }
}
