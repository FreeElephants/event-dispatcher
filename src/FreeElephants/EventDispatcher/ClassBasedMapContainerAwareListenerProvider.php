<?php
declare(strict_types=1);

namespace FreeElephants\EventDispatcher;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class ClassBasedMapContainerAwareListenerProvider implements ListenerProviderInterface
{

    private ContainerInterface $container;
    private array $eventsMap = [];

    public function __construct(
        ContainerInterface $container,
        array $eventsMap
    )
    {
        $this->container = $container;
        $this->eventsMap = $eventsMap;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $listeners = (array) $this->eventsMap[get_class($event)] ?? [];
        return array_map(fn(string $listener) => $this->container->get($listener), $listeners);
    }
}
