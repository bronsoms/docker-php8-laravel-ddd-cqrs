<?php

namespace Tests;

use Shared\Application\Service\Company\DefaultCompanyLocaleRetriever;
use Shared\Domain\Model\Language;
use Closure;
use Illuminate\Contracts\Console\Kernel;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PDO;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\SDK\Tools\Stub\User\Model\UserLanguageStub;

class ServiceProviderTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    private $registerMakeCount = [];

    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function mockAppBind(ObjectProphecy $applicationprophesize, $class, Closure $closure)
    {
        $applicationprophesize->bind($class, Argument::that($closure))
            ->will(function ($args) use ($class) {
                $object = $args[1]->__invoke();
                Assert::assertInstanceOf($class, $object);
                return $object;
            })
            ->shouldBeCalled();
    }

    protected function mockDirectAppBind(ObjectProphecy $applicationprophesize, string $class, string $bindingClass)
    {
        $applicationprophesize->bind($class, $bindingClass)->shouldBeCalled();
    }

    protected function mockAppNamedBind(ObjectProphecy $applicationprophesize, $class, Closure $closure)
    {
        $applicationprophesize->bind($class, Argument::that($closure))
            ->will(function ($args) {
                return $args[1]->__invoke();
            })
            ->shouldBeCalled();
    }

    protected function registerMakeRevealed(ObjectProphecy $app, string $className)
    {
        return $this->registerMake($app, $className)->reveal();
    }

    protected function registerMake(ObjectProphecy $app, string $className)
    {
        if (false === isset($this->registerMakeCount[$className])) {
            $this->registerMakeCount[$className] = [
                'count' => 0,
                'mock' => $this->prophesize($className),
            ];
        }

        $this->registerMakeCount[$className]['count']++;

        $app->make($className)
            ->shouldBeCalledTimes($this->registerMakeCount[$className]['count'])
            ->willReturn($this->registerMakeCount[$className]['mock']);

        return $this->registerMakeCount[$className]['mock'];
    }

    protected function registerMakeNamedReveal(ObjectProphecy $app, string $name, string $class)
    {
        $prophecy = $this->prophesize($class);

        $app->make($name)
            ->shouldBeCalled()
            ->willReturn($prophecy);

        return $prophecy->reveal();
    }

    protected function registerMakeWithReturnReveal(ObjectProphecy $app, string $makeIdentifier, ObjectProphecy $return)
    {
        $app->make($makeIdentifier)
            ->willReturn($return)
            ->shouldBeCalled();

        return $return->reveal();
    }

    protected function mockAppSingleton(ObjectProphecy $applicationprophesize, $className, Closure $closure = null)
    {
        if(null !== $closure) {
            $closure = Argument::that($closure);
        }

        $applicationprophesize->singleton($className, $closure)
            ->will(function ($args) use ($className) {
                if(isset($args[1])) {
                    Assert::assertInstanceOf($className, $args[1]->__invoke());
                }
            })
            ->shouldBeCalled();
    }
}
