<?php

namespace Shared\Application\Service;

interface IdGenerator
{
    /**
     * @return mixed
     */
    public function next();
}
