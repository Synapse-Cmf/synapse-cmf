<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\DomainInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\AddComponentCommand;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events;

/**
 * Unit test class for Zone AddComponent command.
 */
class AddComponentCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     *
     * This function have to create a new Component using ComponentDomain, then
     * add it into current zone, at the end of the component collection
     */
    public function testResolve()
    {
        $asserter = $this;
        $zone = (new Zone())->setComponents(new ComponentCollection(array(
            new Component(), new Component(), new Component(),
        )));
        $component = (new Component())
            ->setComponentType(new ComponentType())
            ->setData(array('foo' => 'bar'))
        ;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator->validate(Argument::type(Zone::class), null, array('Zone', 'edition'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(Events::ZONE_EDITED, Argument::type(Event::class))
            ->will(function ($args) use ($asserter, $component) {
                $zone = $args[1]->getZone();
                $asserter->assertContains($component, $zone->getComponents());
            })
            ->shouldBeCalled()
        ;

        // Component domain
        $componentDomain = $this->prophesize(DomainInterface::class);
        $componentDomain->create(Argument::type(ComponentTypeInterface::class), Argument::type('array'))
            ->willReturn($component)
            ->shouldBeCalled()
        ;

        // Command
        $command = new AddComponentCommand($componentDomain->reveal());
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());
        $command->init($zone);
        $command->setComponentType(new ComponentType());
        $command->setComponentData(array('foo' => 'bar'));

        $this->assertEquals($component, $command->resolve());
    }
}
