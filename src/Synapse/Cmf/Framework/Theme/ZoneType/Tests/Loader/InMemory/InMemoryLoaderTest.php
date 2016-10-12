<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Tests\Loader\InMemory;

use Majora\Framework\Normalizer\MajoraNormalizer;
use Prophecy\Argument;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\LoaderInterface;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneTypeCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\InMemory\InMemoryLoader;

/**
 * Unit test class for ZoneType InMemory loader class.
 */
class InMemoryLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests zone type registration method.
     */
    public function testRegisterZoneType()
    {
        $normalizer = $this->prophesize(MajoraNormalizer::class);
        $normalizer->denormalize(Argument::type('array'), ZoneType::class)
            ->willReturn((new ZoneType())->setId(42))
        ;

        $componentTypeLoader = $this->prophesize(LoaderInterface::class);
        $componentTypeLoader->retrieve('component_type_1')
            ->willReturn($componentType1 = (new ComponentType())->setId('component_type_1'))
        ;
        $componentTypeLoader->retrieve('component_type_2')
            ->willReturn($componentType2 = (new ComponentType())->setId('component_type_2'))
        ;

        $zoneLoader = new InMemoryLoader(
            ZoneTypeCollection::class,
            $normalizer->reveal(),
            $componentTypeLoader->reveal()
        );

        $zoneLoader->registerZoneType(array(
            'id' => 42,
            'name' => 'zone_type_42',
            'order' => 1,
            'components' => array('component_type_1', 'component_type_2'),
        ));

        $this->assertInstanceOf(
            ZoneType::class,
            $zoneType = $zoneLoader->retrieve(42)
        );
        $this->assertCount(2, $zoneType->getAllowedComponentTypes());
        $this->assertEquals(
            $componentType1,
            $zoneType->getAllowedComponentTypes()->get('component_type_1')
        );
        $this->assertEquals(
            $componentType2,
            $zoneType->getAllowedComponentTypes()->get('component_type_2')
        );
    }
}
