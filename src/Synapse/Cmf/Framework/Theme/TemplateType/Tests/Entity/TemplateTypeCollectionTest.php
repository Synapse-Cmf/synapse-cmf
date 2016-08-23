<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateTypeCollection;

/**
 * Unit test class for TemplateTypeCollection.
 */
class TemplateTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $templateTypeCollection = new TemplateTypeCollection();
        $templateTypeCollection->denormalize(array(
            'template_type_1' => array('id' => 42),
            'template_type_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            TemplateType::class,
            $templateTypeCollection->get('template_type_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            TemplateType::class,
            $templateTypeCollection->get('template_type_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'template_type_1' => 42,
                'template_type_2' => 66,
            ),
            $templateTypeCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
