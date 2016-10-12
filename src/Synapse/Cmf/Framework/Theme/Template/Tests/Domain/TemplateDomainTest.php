<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Domain;

use Majora\Framework\Domain\Action\ActionFactory;
use Prophecy\Argument;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface as ContentTypeLoader;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Domain\Command\CreateLocalCommand;
use Synapse\Cmf\Framework\Theme\Template\Domain\TemplateDomain;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Template command proxy class test.
 */
class TemplateDomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create and return an empty Content object.
     *
     * @return Content
     */
    public function getContentMock()
    {
        return new Content(
            $this->prophesize(ContentInterface::class)->reveal(),
            new ContentType()
        );
    }

    /**
     * Case data providers for local creation calls.
     */
    public function localCreationCasesProvider()
    {
        return array(

            'synapse_objects_parameters' => array(
                $this->getContentMock(),
                new TemplateType(),
            ),

            'content_objects_parameters' => array(
                $this->prophesize(ContentInterface::class)->reveal(),
                new TemplateType(),
            ),

            // 'template_type_id' => array(

            // )

        );
    }

    /**
     * Tests createLocal() method.
     *
     * @dataProvider localCreationCasesProvider
     */
    public function testCreateLocal($content, $templateType, $zones = null)
    {
        // Mocks
        $contentResolver = $this->prophesize(ContentResolver::class);
        $contentResolver->resolve(Argument::type(ContentInterface::class))
            ->willReturn($this->getContentMock())
        ;

        $contentTypeLoader = $this->prophesize(ContentTypeLoader::class);

        $templateTypeLoader = $this->prophesize(TemplateTypeLoader::class);

        $createCommand = $this->prophesize(CreateLocalCommand::class);
        $createCommand->setZones(Argument::type(ZoneCollection::class))
            ->will(function ($args, $object) {
                return $object;
            })
        ;
        $createCommand->setContent(Argument::type(Content::class))
            ->will(function ($args, $object) {
                return $object;
            })
        ;
        $createCommand->setTemplateType(Argument::type(TemplateTypeInterface::class))
            ->will(function ($args, $object) {
                return $object;
            })
        ;
        $createCommand->resolve()
            ->willReturn(new Template())
        ;

        // Domain
        $templateDomain = new TemplateDomain(
            new ActionFactory(array(
                'create_local' => $createCommand->reveal(),
            )),
            $contentResolver->reveal(),
            $contentTypeLoader->reveal(),
            $templateTypeLoader->reveal()
        );

        // Assertions
        $this->assertInstanceOf(
            TemplateInterface::class,
            $templateDomain->createLocal($content, $templateType, $zones)
        );
    }
}
