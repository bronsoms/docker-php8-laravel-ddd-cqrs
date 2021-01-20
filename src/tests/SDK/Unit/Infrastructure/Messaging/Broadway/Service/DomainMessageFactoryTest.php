<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging\Broadway\Service;

use App\SDK\Infrastructure\Messaging\Broadway\Service\DomainMessageFactory;
use Tests\SDK\Tools\RandomNumberGenerator;
use Broadway\Domain\Metadata;
use Tests\TestCase;

class DomainMessageFactoryTest extends TestCase
{
    private const TIME_ZONE_OFFSET = '+00:00';
    private const TIMEZONE_BY_DEFAULT = 'UTC';

    public function testDomainMessageIsValid()
    {
        $existingTimezone = date_default_timezone_get();
        date_default_timezone_set(self::TIMEZONE_BY_DEFAULT);

        $id = (string) RandomNumberGenerator::integer();
        $playHead = RandomNumberGenerator::integer();
        $metadata = new Metadata(['test' => RandomNumberGenerator::integer()]);
        $payload = (string) RandomNumberGenerator::integer();

        $domainMessage = DomainMessageFactory::build(
            $id,
            $playHead,
            $metadata,
            $payload
        );

        static::assertSame($id, $domainMessage->getId());
        static::assertSame($playHead, $domainMessage->getPlayhead());
        static::assertSame($metadata, $domainMessage->getMetadata());
        static::assertSame($payload, $domainMessage->getPayload());
        static::assertEquals(self::TIME_ZONE_OFFSET, $domainMessage->getRecordedOn()->toNative()->getTimezone()->getName());

        date_default_timezone_set($existingTimezone);
    }
}
