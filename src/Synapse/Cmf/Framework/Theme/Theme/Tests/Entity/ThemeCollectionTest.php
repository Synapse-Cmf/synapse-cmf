<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Tests\Entity;

use Synapse\Cmf\Framework\Theme\Theme\Entity\Theme;
use Synapse\Cmf\Framework\Theme\Theme\Entity\ThemeCollection;

/**
 * Unit test class for ThemeCollection.
 */
class ThemeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $themeCollection = new ThemeCollection();
        $themeCollection->denormalize(array(
            'theme_1' => array('id' => 42),
            'theme_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Theme::class,
            $themeCollection->get('theme_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Theme::class,
            $themeCollection->get('theme_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'theme_1' => 42,
                'theme_2' => 66,
            ),
            $themeCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
