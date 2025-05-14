<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging\Broadway\Service;

use Shared\Infrastructure\Messaging\Broadway\Service\DateTimeFactory;
use Broadway\Domain\DateTime;
use Tests\TestCase;
use DateTimeZone;

class DateTimeFactoryTest extends TestCase
{
    private const TIME_ZONE = 'UTC';

    public function testItShouldCreateTimezoneConfiguredByDefault()
    {
        $existingTimezone = date_default_timezone_get();
        date_default_timezone_set(self::TIME_ZONE);
        $dateTime = DateTimeFactory::now();

        static::assertEquals('+00:00', $dateTime->toNative()->getTimezone()->getName());
        date_default_timezone_set($existingTimezone);
    }

    public function testItShouldChangeTimezoneProperly()
    {
        $timeZone = new DateTimeZone(self::TIME_ZONE);
        $dateTime = DateTimeFactory::now($timeZone);

        static::assertEquals('+00:00', $dateTime->toNative()->getTimezone()->getName());
    }

    public function testItShouldHaveTheSameIntervalButNotTheSameTimezone()
    {
        $timeZone = new DateTimeZone(self::TIME_ZONE);

        $dateTime = DateTimeFactory::now($timeZone);

        $broadWayDateTime = DateTime::now();

        $diff = $dateTime->diff($broadWayDateTime);

        static::assertEquals(0, $diff->y);
        static::assertEquals(0, $diff->m);
        static::assertEquals(0, $diff->d);
        static::assertEquals(0, $diff->h);
        static::assertEquals(0, $diff->m);
        static::assertTrue($diff->s < 2);

        static::assertNotEquals(
            $broadWayDateTime->toNative()->getTimezone(),
            $dateTime->toNative()->getTimezone()->getName()
        );
    }
}
