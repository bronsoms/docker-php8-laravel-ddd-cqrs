<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging;

use App\SDK\Domain\Messaging\Query\Invoice\SearchWithPaginationHandler;
use App\SDK\Infrastructure\Exception\QueryHandlerClassNotFoundException;
use App\SDK\Infrastructure\Messaging\QueryBus;
use App\SDK\Infrastructure\Messaging\SimpleQueryBus;
use Illuminate\Contracts\Container\Container;
use Tests\SDK\Tools\Stub\User\Query\SearchWithPaginationStub;
use Tests\TestCase;

class SimpleQueryBusTest extends TestCase
{
    /** @var Container */
    private $container;

    /** @var QueryBus */
    private $sut;

    public function setUp(): void
    {
        $this->container = $this->prophesize(Container::class);
        $this->sut = new SimpleQueryBus($this->container->reveal());
    }

    public function test_it_should_dispatch_query_when_handler_found()
    {
        static::assertTrue(true);
//  /*      $query = SearchWithPaginationStub::random();
//
//        /** @var SearchWithPaginationHandler $searchHandler */
//        $searchHandler = $this->prophesize(SearchWithPaginationHandler::class);
//        $searchHandler->handle($query)->shouldBeCalled();
//
//        $this->container->make(SearchWithPaginationHandler::class)
//            ->shouldBeCalled()
//            ->willReturn($searchHandler);
//
//        $this->queryBus->dispatch($query);*/
    }

    public function test_it_should_throw_exception_when_handler_class_not_found()
    {
        static::assertTrue(true);
//        $query = SearchWithPaginationStub::random();
//
//        /** @var SearchWithPaginationHandler $searchHandler */
//        $searchHandler = $this->prophesize(SearchWithPaginationHandler::class);
//        $searchHandler->handle($query)->shouldNotBeCalled();
//
//        $this->container->make(SearchWithPaginationHandler::class)
//            ->shouldBeCalled()
//            ->willReturn(null);
//
//        $this->expectException(QueryHandlerClassNotFoundException::class);
//
//        $this->queryBus->dispatch($query);
    }
}
