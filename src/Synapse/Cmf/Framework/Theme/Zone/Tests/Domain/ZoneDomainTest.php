<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Domain;

use Majora\Framework\Domain\Action\ActionFactory;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\AddComponentCommand;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\CreateCommand;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\UpdateCommand;
use Synapse\Cmf\Framework\Theme\Zone\Domain\ZoneDomain;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone command proxy test class.
 */
class ZoneDomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests create() method.
     */
    public function testCreate()
    {
        $zoneType = new ZoneType();
        $componentCollection = new ComponentCollection(array(
            new Component(),
            new Component(),
        ));

        $createCommand = $this->prophesize(CreateCommand::class);
        $createCommand->setZoneType($zoneType)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $createCommand->setComponents($componentCollection)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $createCommand->resolve()
            ->willReturn(new Zone())
            ->shouldBeCalled()
        ;

        $zoneDomain = new ZoneDomain(new ActionFactory(array(
            'create' => $createCommand->reveal(),
        )));

        $this->assertInstanceOf(
            ZoneInterface::class,
            $zoneDomain->create($zoneType, $componentCollection)
        );
    }

    /**
     * Tests edit() method.
     */
    public function testEdit()
    {
        $zone = new Zone();
        $componentCollection = new ComponentCollection();

        $updateCommand = $this->prophesize(UpdateCommand::class);
        $updateCommand->init($zone)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $updateCommand->setComponents($componentCollection)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $updateCommand->resolve()
            ->shouldBeCalled()
        ;

        $zoneDomain = new ZoneDomain(new ActionFactory(array(
            'edit' => $updateCommand->reveal(),
        )));
        $zoneDomain->edit($zone, $componentCollection);
    }

    /**
     * Tests addComponent() method.
     */
    public function testAddComponent()
    {
        $zone = new Zone();
        $componentType = new ComponentType();
        $componentData = array('foo' => 'bar');

        $addComponentCommand = $this->prophesize(AddComponentCommand::class);
        $addComponentCommand->init($zone)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $addComponentCommand->setComponentType($componentType)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $addComponentCommand->setComponentData($componentData)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $addComponentCommand->resolve()
            ->willReturn(new Component())
            ->shouldBeCalled()
        ;

        $zoneDomain = new ZoneDomain(new ActionFactory(array(
            'add_component' => $addComponentCommand->reveal(),
        )));
        $this->assertInstanceOf(
            Component::class,
            $zoneDomain->addComponent($zone, $componentType, $componentData)
        );
    }
}
