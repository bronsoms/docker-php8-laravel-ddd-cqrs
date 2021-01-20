<?php

namespace App\SDK\Domain\Messaging\Event;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Messaging\Message;

interface Event extends Message
{
    /**
     * @return mixed
     */
    public function aggregateId();

    public function name(): string;

    /**
     * @throws InvalidParametersException
     */
    public static function fromArray(array $data): self;

    public function serialize(): array;
}
