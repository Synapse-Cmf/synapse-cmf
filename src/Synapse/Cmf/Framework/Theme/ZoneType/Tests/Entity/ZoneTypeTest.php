<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;

/**
 * Unit test class for ZoneType.
 */
class ZoneTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZoneType
     */
    private $zoneType;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->zoneType = new ZoneType();
        $this->reflector = new \ReflectionClass($this->zoneType);
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
        $this->zoneType->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->zoneType),
            sprintf('ZoneType::%s() defines "%s" property current value.',
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
        $property->setValue($this->zoneType, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->zoneType->$method(),
            sprintf('ZoneType::%s() returns current defined "%s" property value.',
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
        $this->zoneType->setId(42);
        $zoneTypeData = $this->zoneType->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $zoneTypeData,
                sprintf('ZoneType "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $zoneTypeData,
                sprintf('ZoneType "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
