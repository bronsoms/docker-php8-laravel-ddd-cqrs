<?php

namespace Shared\Domain\Messaging\Query;

use Shared\Domain\Exception\InvalidParametersException;

interface Query
{
    /**
     * @throws InvalidParametersException
     * @return mixed
     */
    public static function fromArray(array $data);

    public function serialize(): array;
}
