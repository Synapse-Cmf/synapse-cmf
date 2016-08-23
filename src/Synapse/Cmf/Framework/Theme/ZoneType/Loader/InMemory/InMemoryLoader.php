<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Loader\InMemory;

use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;
use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\LoaderInterface as ComponentTypeLoader;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\LoaderInterface;

/**
 * ZoneType loader implementation using server memory.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;

    /**
     * @var ComponentTypeLoader
     */
    protected $componentTypeLoader;

    /**
     * Construct.
     *
     * @param string              $collectionClass
     * @param MajoraNormalizer    $normalizer
     * @param ComponentTypeLoader $componentTypeLoader
     */
    public function __construct(
        $collectionClass,
        MajoraNormalizer $normalizer,
        ComponentTypeLoader $componentTypeLoader
    ) {
        $this->setUp($collectionClass, $normalizer);
        $this->componentTypeLoader = $componentTypeLoader;
    }

    /**
     * Register a new ZoneType into loader.
     *
     * @param array $zoneTypeData
     */
    public function registerZoneType(array $zoneTypeData)
    {
        $zoneType = $this->normalizer->denormalize(
            array(
                'id' => $zoneTypeData['id'],
                'name' => $zoneTypeData['name'],
                'order' => $zoneTypeData['order'],
            ),
            $this->entityCollection->getEntityClass()
        );
        foreach ($zoneTypeData['components'] as $componentTypeId) {
            $zoneType->getAllowedComponentTypes()->set(
                $componentTypeId,
                $this->componentTypeLoader->retrieve($componentTypeId)
            );
        }

        $this->entityCollection->set($zoneType->getId(), $zoneType);
    }
}
