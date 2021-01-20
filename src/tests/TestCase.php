<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use ProphecyTrait;
    use Faker;

    protected function setUp(): void
    {
        parent::setUp();
    }
}
