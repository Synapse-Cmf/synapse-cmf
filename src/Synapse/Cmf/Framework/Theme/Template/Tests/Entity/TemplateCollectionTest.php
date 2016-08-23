<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Entity;

use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Entity\TemplateCollection;

/**
 * Unit test class for TemplateCollection.
 */
class TemplateCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $templateCollection = new TemplateCollection();
        $templateCollection->denormalize(array(
            'template_1' => array('id' => 42),
            'template_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Template::class,
            $templateCollection->get('template_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Template::class,
            $templateCollection->get('template_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'template_1' => 42,
                'template_2' => 66,
            ),
            $templateCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
