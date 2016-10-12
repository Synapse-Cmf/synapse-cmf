<?php

namespace Synapse\Cmf\Framework\Theme\Variation\Tests\Entity;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;

/**
 * Unit test class for Variation value object.
 */
class VariationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configuration provider.
     *
     * @return array
     */
    public function configurationProvider()
    {
        return array(

            'existing_config' => array(
                array('namespace' => array('element' => array('key' => 42))),
                42,
                'namespace', 'element', 'key',
            ),

            'no_config' => array(
                array(),
                'default',
                'namespace', 'element', 'key', 'default',
            ),

            'bad_config' => array(
                array('namespace' => array('element' => array('key' => 42))),
                'default',
                'fake_namespace', 'element', 'key', 'default',
            ),

            'empty_config' => array(
                array('namespace' => array('element' => array('key' => null))),
                'default',
                'fake_namespace', 'element', 'key', 'default',
            ),

        );
    }

    /**
     * Tests getConfiguration() method.
     *
     * @dataProvider configurationProvider
     */
    public function testGetConfiguration(array $configuration, $expected, $namespace, $element, $key, $default = null)
    {
        $this->assertEquals(
            $expected,
            (new Variation($configuration, new PropertyAccessor()))->getConfiguration(
                $namespace,
                $element,
                $key,
                $default
            )
        );
    }
}
