<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\UpdateCommand;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;
use Synapse\Cmf\Framework\Theme\Component\Event\Events;

/**
 * Unit test class for Component UpdateCommand.
 */
class UpdateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testResolve()
    {
        $asserter = $this;
        $component = (new Component())->setData(
            $initialData = array('foo' => 'bar')
        );

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator->validate(Argument::type(Component::class), null, array('Component', 'edition'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(Events::COMPONENT_EDITED, Argument::type(Event::class))
            ->shouldBeCalled()
        ;

        // Command
        $command = new UpdateCommand();
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());
        $command->init($component);
        $this->assertEquals($initialData, $command->getData());

        $command->setData($data = array('foo' => 'bar'));
        $this->assertEquals($data, $command->getData());

        $command->resolve();
        $this->assertEquals(
            $data,
            $command->getComponent()->getData()
        );
    }
}
