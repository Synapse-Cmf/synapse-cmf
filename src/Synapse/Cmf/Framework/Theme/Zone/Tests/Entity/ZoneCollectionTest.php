<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Unit test class for ZoneCollection.
 */
class ZoneCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test collection sorting on zone type order.
     */
    public function testSortByZoneType()
    {
        $zone1 = (new Zone())->setZoneType((new ZoneType())
            ->setOrder(2)
        );
        $zone2 = (new Zone())->setZoneType((new ZoneType())
            ->setOrder(3)
        );
        $zone3 = (new Zone())->setZoneType((new ZoneType())
            ->setOrder(1)
        );

        $this->assertEquals(
            new ZoneCollection(array($zone3, $zone1, $zone2)),
            (new ZoneCollection(array($zone1, $zone2, $zone3)))->sortByZoneType()
        );
    }

    /**
     * Test zone type name indexation.
     */
    public function testIndexByZoneType()
    {
        $zone1 = (new Zone())->setZoneType((new ZoneType())
            ->setName('zone_1')
        );
        $zone2 = (new Zone())->setZoneType((new ZoneType())
            ->setName('zone_2')
        );
        $zone3 = (new Zone())->setZoneType((new ZoneType())
            ->setName('zone_3')
        );

        $this->assertEquals(
            new ZoneCollection(array(
                'zone_1' => $zone1,
                'zone_3' => $zone3,
                'zone_2' => $zone2,
            )),
            (new ZoneCollection(array($zone1, $zone3, $zone2)))->indexByZoneType()
        );
    }

    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $zoneCollection = new ZoneCollection();
        $zoneCollection->denormalize(array(
            'zone_1' => array('id' => 42),
            'zone_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Zone::class,
            $zoneCollection->get('zone_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Zone::class,
            $zoneCollection->get('zone_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'zone_1' => 42,
                'zone_2' => 66,
            ),
            $zoneCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
