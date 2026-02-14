<?php
declare(strict_types=1);

namespace FreeElephants\EventDispatcher;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcherTest extends TestCase
{

    public function testDispatch(): void
    {
        $event = new TestEvent();
        $listenerProvider = $this->createMock(ListenerProviderInterface::class);
        $listenerProvider->expects($this->once())->method('getListenersForEvent')->willReturn([
            function (object $event) {
            },
            function (object $event) {
                $event->stopPropagation();
            },
            function (object $event) {
                $this->fail('listener after stop call');
            },
        ])->with($event);

        $dispatcher = new EventDispatcher($listenerProvider);

        $dispatcher->dispatch($event);
    }
}

class TestEvent implements StoppableEventInterface
{
    private bool $isStopped = false;

    public function stopPropagation(): void
    {
        $this->isStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isStopped;
    }
}
