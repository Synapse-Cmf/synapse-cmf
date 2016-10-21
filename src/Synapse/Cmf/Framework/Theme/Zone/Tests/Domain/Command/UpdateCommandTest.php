<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\UpdateCommand;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events;

/**
 * Unit test class for Zone UpdateCommand.
 */
class UpdateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testResolve()
    {
        $zone = (new Zone())->setComponents($initialComponents = new ComponentCollection(array(
            new Component(), new Component(), new Component(),
        )));

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator->validate(Argument::type(Zone::class), null, array('Zone', 'edition'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(Events::ZONE_EDITED, Argument::type(Event::class))
            ->shouldBeCalled()
        ;

        // Command
        $command = new UpdateCommand();
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());

        $command->init($zone);
        $this->assertEquals($initialComponents, $command->getComponents());

        $command->setComponents($components = new ComponentCollection(array(
            new Component(), new Component(),
        )));
        $this->assertEquals($components, $command->getComponents());

        $command->resolve();
        $this->assertEquals(
            $components,
            $command->getZone()->getComponents()
        );
    }
}
