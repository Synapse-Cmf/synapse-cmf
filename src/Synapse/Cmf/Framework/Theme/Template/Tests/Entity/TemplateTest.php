<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Unit test class for Template.
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var \ReflectionClass
     */
    private $reflector;

    /**
     * SetUp method.
     */
    public function setUp()
    {
        $this->template = new Template();
        $this->reflector = new \ReflectionClass($this->template);
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
            'template_type' => array('templateType', new TemplateType()),
            'content' => array('content', new Content(
                $this->prophesize(ContentInterface::class)->reveal(),
                new ContentType()
            )),
            'content_type' => array('contentType', new ContentType()),
            'global_template' => array('globalTemplate', new Template()),
            'zones' => array('zones', new ZoneCollection()),
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
        $this->template->$method($definedValue);
        $this->assertEquals(
            $definedValue,
            $property->getValue($this->template),
            sprintf('Template::%s() defines "%s" property current value.',
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
        $property->setValue($this->template, $expectedValue);

        $method = 'get'.ucfirst($propertyName);
        $this->assertEquals(
            $expectedValue,
            $this->template->$method(),
            sprintf('Template::%s() returns current defined "%s" property value.',
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
        $this->template->setId(42);
        $templateData = $this->template->normalize($scope);

        if (!is_array($expectedKeys)) {
            return $this->assertInternalType(
                $expectedKeys,
                $templateData,
                sprintf('Template "%s" scope provides a single value as %s.', $scope, $expectedKeys)
            );
        }

        foreach ($expectedKeys as $expectedKey) {
            $this->assertArrayHasKey(
                $expectedKey,
                $templateData,
                sprintf('Template "%s" scope provides an array with "%s" key.', $scope, $expectedKey)
            );
        }
    }

    /**
     * Test "local" scope definition.
     */
    public function testScopeLocal()
    {
        $this->assertEquals(
            TemplateInterface::LOCAL_SCOPE,
            (new Template())->setLocal()->getScope()
        );
    }

    /**
     * Test "global" scope definition.
     */
    public function testScopeGlobal()
    {
        $this->assertEquals(
            TemplateInterface::GLOBAL_SCOPE,
            (new Template())->setGlobal()->getScope()
        );
    }
}
