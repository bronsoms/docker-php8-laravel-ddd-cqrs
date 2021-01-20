<?php

namespace App\SDK\Domain\Messaging\Query;

use App\SDK\Domain\Exception\InvalidParametersException;

interface Query
{
    /**
     * @throws InvalidParametersException
     * @return mixed
     */
    public static function fromArray(array $data);

    public function serialize(): array;
}
