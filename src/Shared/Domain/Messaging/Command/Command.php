<?php

namespace Shared\Domain\Messaging\Command;

use Shared\Domain\Exception\InvalidParametersException;
use Shared\Domain\Messaging\Message;

interface Command extends Message
{
    /**
     * @throws InvalidParametersException
     */
    public static function fromArray(array $data);

    public function serialize(): array;
}
