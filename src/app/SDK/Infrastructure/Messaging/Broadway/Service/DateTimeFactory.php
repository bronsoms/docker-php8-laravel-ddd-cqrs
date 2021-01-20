<?php

namespace App\SDK\Infrastructure\Messaging\Broadway\Service;

use Broadway\Domain\DateTime as BroadwayDateTime;
use DateTimeImmutable;
use DateTimeZone;

class DateTimeFactory
{
    public static function now(DateTimeZone $timeZone = null): BroadwayDateTime
    {
        $timeZone = $timeZone ?? new DateTimeZone(date_default_timezone_get());

        $dateTimeWithProperTimeZone = DateTimeImmutable::createFromFormat(
            'U.u',
            sprintf('%.6F', microtime(true))
        )->setTimezone($timeZone);

        return BroadwayDateTime::fromString(
            $dateTimeWithProperTimeZone->format(BroadwayDateTime::FORMAT_STRING)
        );
    }
}
