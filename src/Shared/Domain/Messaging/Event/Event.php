<?php

namespace Shared\Domain\Messaging\Event;

use Shared\Domain\Exception\InvalidParametersException;
use Shared\Domain\Messaging\Message;

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
