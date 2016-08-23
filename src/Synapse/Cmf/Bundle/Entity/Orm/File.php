<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Media\File\Entity\File as SynapseFile;

/**
 * Synapse file specific Orm implementation.
 */
class File extends SynapseFile implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getPhysicalFile()
    {
        return $this->load('physicalFile');
    }
}
