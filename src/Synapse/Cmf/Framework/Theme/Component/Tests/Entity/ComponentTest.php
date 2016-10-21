<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;

/**
 * Unit test class for Component.
 */
class ComponentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Component
     */
    private $component;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->component = new Component();
        $this->reflector = new \ReflectionClass($this->component);
    }

    /**
     * Provider for accessor tests.
     *
     * @return array
     */
    public function propertyMapProvider()
    {
        return array(
            'id' => array('id', 42),
            'data' => array('data', array('hello' => 'world')),
            'component_type' => array('componentType', new ComponentType()),
            'ranking' => array('ranking', 11),
        );
    }

    /**
     * Tests setters.
     *
     * @dataProvider propertyMapProvider
     */
    public function testSet($propertyName, $definedValue)
    {
        $property = $this->reflector->getProperty($propertyName);
        $property->setAccessible(true);

        $method = 'set'.ucfirst($propertyName);
        $this->component->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->component),
            sprintf('Component::%s() defines "%s" property current value.',
                $method,
                $propertyName
            )
        );
    }

    /**
     * Tests getters.
     *
     * @dataProvider propertyMapProvider
     */
    public function testGet($propertyName, $expectedValue)
    {
        $property = $this->reflector->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($this->component, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->component->$method(),
            sprintf('Component::%s() returns current defined "%s" property value.',
                $method,
                $propertyName
            )
        );
    }

    /**
     * Provider for normalization tests.
     *
     * @return array()
     */
    public function normalizationCasesProvider()
    {
        return array(
            'id' => array('id', 'int'),
            'default' => array('default', array('id')),
        );
    }

    /**
     * Tests normalization scopes.
     *
     * @dataProvider normalizationCasesProvider
     */
    public function testNormalizationScopes($scope, $expectedKeys)
    {
        $this->component->setId(42);
        $componentData = $this->component->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $componentData,
                sprintf('Component "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $componentData,
                sprintf('Component "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }

    /**
     * Provider for getData test.
     *
     * @return array
     */
    public function singleDataProvider()
    {
        return array(
            'defined_key' => array('foo', 'default', 'bar'),
            'empty_value' => array('empty', 'default', 'default'),
            'undefined_key' => array('fake', 'default', 'default'),
        );
    }

    /**
     * Tests Component special get.
     *
     * @dataProvider singleDataProvider
     */
    public function testGetSingleData($key, $default, $return)
    {
        $component = (new Component())->setData(array(
            'foo' => 'bar',
            'empty' => null,
        ));

        $this->assertEquals(
            $return,
            $component->getData($key, $default)
        );
    }
}
