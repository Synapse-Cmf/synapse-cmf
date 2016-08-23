<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;

/**
 * Unit test class for TemplateType.
 */
class TemplateTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateType
     */
    private $templateType;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->templateType = new TemplateType();
        $this->reflector = new \ReflectionClass($this->templateType);
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
        $this->templateType->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->templateType),
            sprintf('TemplateType::%s() defines "%s" property current value.',
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
        $property->setValue($this->templateType, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->templateType->$method(),
            sprintf('TemplateType::%s() returns current defined "%s" property value.',
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
        $this->templateType->setId(42);
        $templateTypeData = $this->templateType->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $templateTypeData,
                sprintf('TemplateType "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $templateTypeData,
                sprintf('TemplateType "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }
}
