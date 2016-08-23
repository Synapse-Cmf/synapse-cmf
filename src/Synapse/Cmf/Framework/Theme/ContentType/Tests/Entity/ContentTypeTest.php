<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;

/**
 * Unit test class for ContentType.
 */
class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContentType
     */
    private $contentType;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->contentType = new ContentType();
        $this->reflector = new \ReflectionClass($this->contentType);
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
        $this->contentType->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->contentType),
            sprintf('ContentType::%s() defines "%s" property current value.',
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
        $property->setValue($this->contentType, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->contentType->$method(),
            sprintf('ContentType::%s() returns current defined "%s" property value.',
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
        $this->contentType->setId(42);
        $contentTypeData = $this->contentType->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $contentTypeData,
                sprintf('ContentType "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $contentTypeData,
                sprintf('ContentType "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
