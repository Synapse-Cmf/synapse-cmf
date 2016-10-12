<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Tests\Loader\InMemory;

use Majora\Framework\Normalizer\MajoraNormalizer;
use Prophecy\Argument;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateTypeCollection;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\InMemory\InMemoryLoader;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\LoaderInterface;

/**
 * Unit test class for TemplateType InMemory loader class.
 */
class InMemoryLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests zone type registration method.
     */
    public function testRegisterZoneType()
    {
        $normalizer = $this->prophesize(MajoraNormalizer::class);
        $normalizer->denormalize(Argument::type('array'), TemplateType::class)
            ->willReturn((new TemplateType())->setId(42))
        ;

        $zoneTypeLoader = $this->prophesize(LoaderInterface::class);
        $zoneTypeLoader->retrieve('zone_type_1')
            ->willReturn($zoneType1 = (new ZoneType())->setId('zone_type_1'))
        ;
        $zoneTypeLoader->retrieve('zone_type_2')
            ->willReturn($zoneType2 = (new ZoneType())->setId('zone_type_2'))
        ;

        $templateTypeLoader = new InMemoryLoader(
            TemplateTypeCollection::class,
            $normalizer->reveal(),
            $zoneTypeLoader->reveal()
        );

        $templateTypeLoader->registerTemplateType(array(
            'id' => 42,
            'name' => 'template_type_42',
            'zones' => array('zone_type_1', 'zone_type_2'),
        ));

        $this->assertInstanceOf(
            TemplateType::class,
            $templateType = $templateTypeLoader->retrieve(42)
        );

        $this->assertCount(2, $templateType->getZoneTypes());
        $this->assertEquals(
            $zoneType1,
            $templateType->getZoneTypes()->get('zone_type_1')
        );
        $this->assertEquals(
            $zoneType2,
            $templateType->getZoneTypes()->get('zone_type_2')
        );
    }
}
