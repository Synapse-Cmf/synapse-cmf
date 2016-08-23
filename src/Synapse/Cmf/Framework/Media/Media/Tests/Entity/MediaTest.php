<?php

namespace Synapse\Cmf\Framework\Media\Media\Tests\Entity;

use Synapse\Cmf\Framework\Media\Media\Entity\Media;

/**
 * Unit test class for Media.
 */
class MediaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Media
     */
    private $media;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->media = new Media();
        $this->reflector = new \ReflectionClass($this->media);
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
        $this->media->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->media),
            sprintf('Media::%s() defines "%s" property current value.',
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
        $property->setValue($this->media, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->media->$method(),
            sprintf('Media::%s() returns current defined "%s" property value.',
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
        $this->media->setId(42);
        $mediaData = $this->media->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $mediaData,
                sprintf('Media "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $mediaData,
                sprintf('Media "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
