<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\CreateCommand;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events;

/**
 * Unit test class for Zone CreateCommand.
 */
class CreateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testResolve()
    {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator->validate(Argument::type(Zone::class), null, array('Zone', 'creation'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(Events::ZONE_CREATED, Argument::type(Event::class))
            ->shouldBeCalled()
        ;

        // Command
        $command = new CreateCommand(Zone::class);
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());

        $command->setZoneType($zoneType = new ZoneType());
        $command->setComponents($components = new ComponentCollection(array(
            new Component(), new Component(),
        )));

        $this->assertInstanceOf(Zone::class, $zone = $command->resolve());
        $this->assertEquals($zoneType, $zone->getZoneType());
        $this->assertEquals($components, $zone->getComponents());
    }
}
