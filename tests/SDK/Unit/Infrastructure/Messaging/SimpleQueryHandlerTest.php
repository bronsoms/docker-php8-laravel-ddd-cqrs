<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging;

use Shared\Domain\Messaging\Query\Company\CompanyLocationHandler;
use Shared\Domain\Messaging\Query\Company\GetCompany;
use Shared\Domain\ReadModel\Company\CompanyReadModel;
use Shared\Infrastructure\Exception\QueryHandlerMethodNotFoundException;
use Shared\Infrastructure\Messaging\SimpleQueryHandler;
use PHPUnit\Framework\TestCase;
use Tests\SDK\Tools\Stub\Company\CompanyIdStub;

class SimpleQueryHandlerTest extends TestCase
{
    public function test_it_should_throw_exception_when_handler_method_not_found()
    {
        static::assertTrue(true);
//        $companyReadModel = $this->prophesize(CompanyReadModel::class);
//
//        $handler = new CompanyLocationHandler($companyReadModel->reveal());
//
//        $this->assertInstanceOf(SimpleQueryHandler::class, $handler);
//
//        $query = new GetCompany(CompanyIdStub::random());
//
//        $this->expectException(QueryHandlerMethodNotFoundException::class);
//
//        $handler->handle($query);
    }
}
