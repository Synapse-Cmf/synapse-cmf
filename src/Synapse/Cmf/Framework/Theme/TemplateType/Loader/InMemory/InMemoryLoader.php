<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Loader\InMemory;

use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;
use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\LoaderInterface as ZoneTypeLoader;

/**
 * TemplateType loader implementation using server memory.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;

    /**
     * @var ZoneTypeLoader
     */
    protected $zoneTypeLoader;

    /**
     * Construct.
     *
     * @param string           $collectionClass
     * @param MajoraNormalizer $normalizer
     * @param ZoneTypeLoader   $zoneTypeLoader
     */
    public function __construct(
        $collectionClass,
        MajoraNormalizer $normalizer,
        ZoneTypeLoader $zoneTypeLoader
    ) {
        $this->setUp($collectionClass, $normalizer);
        $this->zoneTypeLoader = $zoneTypeLoader;
    }

    /**
     * Register a new TemplateType into loader.
     *
     * @param array $templateTypeData
     */
    public function registerTemplateType(array $templateTypeData)
    {
        $templateType = $this->normalizer->denormalize(
            array('id' => $templateTypeData['id'], 'name' => $templateTypeData['name']),
            $this->entityCollection->getEntityClass()
        );
        foreach ($templateTypeData['zones'] as $zoneTypeId) {
            $templateType->getZoneTypes()->set(
                $zoneTypeId,
                $this->zoneTypeLoader->retrieve($zoneTypeId)
            );
        }

        $this->entityCollection->set($templateType->getId(), $templateType);
    }
}
