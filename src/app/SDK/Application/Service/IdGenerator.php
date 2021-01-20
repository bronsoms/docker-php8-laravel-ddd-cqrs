<?php

namespace App\SDK\Application\Service;

interface IdGenerator
{
    /**
     * @return mixed
     */
    public function next();
}
