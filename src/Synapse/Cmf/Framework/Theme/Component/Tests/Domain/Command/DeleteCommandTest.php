<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\DeleteCommand;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;
use Synapse\Cmf\Framework\Theme\Component\Event\Events;

/**
 * Unit test class for Component DeleteCommand.
 */
class DeleteCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testResolve()
    {
        $asserter = $this;
        $givenComponent = new Component();

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(Events::COMPONENT_DELETED, Argument::type(Event::class))
            ->will(function ($args) use ($asserter, $givenComponent) {
                $asserter->assertEquals($givenComponent, $args[1]->getComponent());
            })
            ->shouldBeCalled()
        ;

        // Command
        $command = new DeleteCommand();
        $command->setEventDispatcher($eventDispatcher->reveal());
        $command->init($givenComponent);

        $command->resolve();
    }
}
