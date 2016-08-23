<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Loader\InMemory;

use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;
use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Media\Format\Loader\LoaderInterface as ImageFormatLoader;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\Theme\Loader\LoaderInterface;

/**
 * Theme loader implementation using server memory.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;

    /**
     * @var TemplateTypeLoader
     */
    protected $templateTypeLoader;

    /**
     * @var ImageFormatLoader
     */
    protected $imageFormatLoader;

    /**
     * Construct.
     *
     * @param string             $collectionClass
     * @param MajoraNormalizer   $normalizer
     * @param TemplateTypeLoader $templateTypeLoader
     * @param ImageFormatLoader  $imageFormatLoader
     */
    public function __construct(
        $collectionClass,
        MajoraNormalizer $normalizer,
        TemplateTypeLoader $templateTypeLoader,
        ImageFormatLoader $imageFormatLoader
    ) {
        $this->setUp($collectionClass, $normalizer);
        $this->templateTypeLoader = $templateTypeLoader;
        $this->imageFormatLoader = $imageFormatLoader;
    }

    /**
     * Register a new TemplateType into loader.
     *
     * @param array $themeData
     */
    public function registerTheme(array $themeData)
    {
        $theme = $this->normalizer->denormalize(
            array('id' => $themeData['id'], 'name' => $themeData['name']),
            $this->entityCollection->getEntityClass()
        );
        foreach ($themeData['templates'] as $templateTypeId) {
            $theme->getTemplateTypes()->set(
                $templateTypeId,
                $this->templateTypeLoader->retrieve($templateTypeId)
            );
        }
        foreach ($themeData['image_formats'] as $imageFormatId) {
            $theme->getImageFormats()->set(
                $imageFormatId,
                $this->imageFormatLoader->retrieve($imageFormatId)
            );
        }

        $this->entityCollection->set($theme->getId(), $theme);
    }

    /**
     * @see LoaderInterface::retrieveByName()
     */
    public function retrieveByName($name)
    {
        return $this->retrieve($name);
    }
}
