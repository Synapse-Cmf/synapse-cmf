<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\CreateCommand;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;
use Synapse\Cmf\Framework\Theme\Component\Event\Events;

/**
 * Unit test class for Component CreateCommand.
 */
class CreateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testResolve()
    {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(Argument::type(Component::class), null, array('Component', 'creation'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(Events::COMPONENT_CREATED, Argument::type(Event::class))
            ->will(function ($args) use ($asserter) {
                $asserter->assertInstanceOf(Component::class, $args[1]->getComponent());
            })
            ->shouldBeCalled()
        ;

        // Command
        $command = new CreateCommand(Component::class);
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());

        $command->setComponentType($componentType = new ComponentType());
        $this->assertEquals($componentType, $command->getComponentType());

        $command->setData($data = array('foo' => 'bar'));
        $this->assertEquals($data, $command->getData());

        $this->assertInstanceOf(Component::class, $component = $command->resolve());
        $this->assertEquals($data, $component->getData());
    }

    /**
     * Tests resolve() method when no component type defined.
     */
    public function testResolveException()
    {
        $this->setExpectedException(\BadMethodCallException::class);

        (new CreateCommand())->resolve();
    }
}
