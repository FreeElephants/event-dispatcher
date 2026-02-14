<?php
declare(strict_types=1);

namespace FreeElephants\EventDispatcher;

use FreeElephants\DI\Injector;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ClassBasedMapContainerAwareListenerProviderTest extends TestCase
{

    public function testGetListenersForEvent(): void
    {
        $container = new Injector();
        $container->allowInstantiateNotRegisteredTypes(true);

        $provider = new ClassBasedMapContainerAwareListenerProvider(
            $container,
            [
                FooEvent::class => FooListener::class,
                BarEvent::class => [
                    FooListener::class,
                    BarListener::class,
                ],
            ]
        );

        $this->assertCount(1, $provider->getListenersForEvent(new FooEvent()));
        $this->assertCount(2, $provider->getListenersForEvent(new BarEvent()));
    }
}


class FooEvent
{

}

class BarEvent{}

class FooListener
{
}

class BarListener {}
