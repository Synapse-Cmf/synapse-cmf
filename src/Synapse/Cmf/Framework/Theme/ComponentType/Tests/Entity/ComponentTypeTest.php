<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;

/**
 * Unit test class for ComponentType.
 */
class ComponentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ComponentType
     */
    private $componentType;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->componentType = new ComponentType();
        $this->reflector = new \ReflectionClass($this->componentType);
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
        $this->componentType->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->componentType),
            sprintf('ComponentType::%s() defines "%s" property current value.',
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
        $property->setValue($this->componentType, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->componentType->$method(),
            sprintf('ComponentType::%s() returns current defined "%s" property value.',
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
        $this->componentType->setId(42);
        $componentTypeData = $this->componentType->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $componentTypeData,
                sprintf('ComponentType "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $componentTypeData,
                sprintf('ComponentType "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
