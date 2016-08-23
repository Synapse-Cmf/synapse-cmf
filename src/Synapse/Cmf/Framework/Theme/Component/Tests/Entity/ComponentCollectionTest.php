<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Entity;

use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;

/**
 * Unit test class for ComponentCollection.
 */
class ComponentCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $componentCollection = new ComponentCollection();
        $componentCollection->denormalize(array(
            'component_1' => array('id' => 42),
            'component_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Component::class,
            $componentCollection->get('component_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Component::class,
            $componentCollection->get('component_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'component_1' => 42,
                'component_2' => 66,
            ),
            $componentCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
