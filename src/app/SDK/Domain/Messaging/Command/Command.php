<?php

namespace App\SDK\Domain\Messaging\Command;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Messaging\Message;

interface Command extends Message
{
    /**
     * @throws InvalidParametersException
     */
    public static function fromArray(array $data);

    public function serialize(): array;
}
