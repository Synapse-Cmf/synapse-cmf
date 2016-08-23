<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentTypeCollection;

/**
 * Unit test class for ComponentTypeCollection.
 */
class ComponentTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $componentTypeCollection = new ComponentTypeCollection();
        $componentTypeCollection->denormalize(array(
            'component_type_1' => array('id' => 42),
            'component_type_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            ComponentType::class,
            $componentTypeCollection->get('component_type_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            ComponentType::class,
            $componentTypeCollection->get('component_type_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'component_type_1' => 42,
                'component_type_2' => 66,
            ),
            $componentTypeCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
