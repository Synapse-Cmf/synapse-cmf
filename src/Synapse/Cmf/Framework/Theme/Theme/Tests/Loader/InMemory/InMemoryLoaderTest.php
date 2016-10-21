<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Tests\Loader\InMemory;

use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Media\Format\Entity\Format;
use Synapse\Cmf\Framework\Media\Format\Loader\LoaderInterface as FormatLoader;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\Theme\Entity\Theme;
use Synapse\Cmf\Framework\Theme\Theme\Entity\ThemeCollection;
use Synapse\Cmf\Framework\Theme\Theme\Loader\InMemory\InMemoryLoader;

/**
 * Unit test class for in memory Theme loader implementation.
 */
class InMemoryLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Theme registration method.
     */
    public function testRegisterTheme()
    {
        $normalizer = $this->prophesize(MajoraNormalizer::class);
        $normalizer->denormalize(array('id' => 'synapse_theme', 'name' => 'synapse_theme'), Theme::class)
            ->willReturn((new Theme())
                ->setId('synapse_theme')
                ->setName('synapse_theme')
            )
        ;

        $templateTypeLoader = $this->prophesize(TemplateTypeLoader::class);
        $templateTypeLoader->retrieve('template_1')
            ->willReturn((new TemplateType())->setId('template_1'))
        ;
        $templateTypeLoader->retrieve('template_2')
            ->willReturn((new TemplateType())->setId('template_2'))
        ;

        $imageFormatLoader = $this->prophesize(FormatLoader::class);
        $imageFormatLoader->retrieve('format_1')
            ->willReturn((new Format())->setId('format_1'))
        ;
        $imageFormatLoader->retrieve('format_2')
            ->willReturn((new Format())->setId('format_2'))
        ;

        $themeLoader = new InMemoryLoader(
            ThemeCollection::class,
            $normalizer->reveal(),
            $templateTypeLoader->reveal(),
            $imageFormatLoader->reveal()
        );

        $themeLoader->registerTheme(array(
            'id' => 'synapse_theme',
            'templates' => array('template_1', 'template_2'),
            'image_formats' => array('format_1', 'format_2'),
        ));

        $this->assertEquals(
            $theme = $themeLoader->retrieve('synapse_theme'),
            $themeLoader->retrieveByName('synapse_theme')
        );

        $this->assertCount(2, $templateTypes = $theme->getTemplateTypes());
        $this->assertInstanceOf(TemplateType::class, $templateTypes->get('template_1'));
        $this->assertInstanceOf(TemplateType::class, $templateTypes->get('template_2'));

        $this->assertCount(2, $imageFormats = $theme->getImageFormats());
        $this->assertInstanceOf(Format::class, $imageFormats->get('format_1'));
        $this->assertInstanceOf(Format::class, $imageFormats->get('format_2'));
    }
}
