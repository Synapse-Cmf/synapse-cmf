<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Entity;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;

/**
 * Unit test class for FormattedImage.
 */
class FormattedImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormattedImage
     */
    private $formattedImage;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->formattedImage = new FormattedImage();
        $this->reflector = new \ReflectionClass($this->formattedImage);
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
        $this->formattedImage->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->formattedImage),
            sprintf('FormattedImage::%s() defines "%s" property current value.',
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
        $property->setValue($this->formattedImage, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->formattedImage->$method(),
            sprintf('FormattedImage::%s() returns current defined "%s" property value.',
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
        $this->formattedImage->setId(42);
        $formattedImageData = $this->formattedImage->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $formattedImageData,
                sprintf('FormattedImage "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $formattedImageData,
                sprintf('FormattedImage "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
