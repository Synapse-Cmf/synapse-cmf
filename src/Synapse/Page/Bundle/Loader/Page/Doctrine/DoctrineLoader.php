<?php

namespace Synapse\Page\Bundle\Loader\Page\Doctrine;

use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;
use Synapse\Page\Bundle\Loader\Page\LoaderInterface;

/**
 * Doctrine Page loading implementation.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;

    /**
     * Override to always get ordered tree.
     *
     * @see DoctrineLoaderTrait::createQuery()
     */
    protected function createQuery($alias = 'entity')
    {
        return $this->getEntityRepository()->createQueryBuilder($alias)
            ->orderBy('entity.lft', 'ASC')
        ;
    }

    /**
     * @see LoaderInterface::retrieveByPath()
     */
    public function retrieveByPath($path, $online = true)
    {
        return $this->retrieveOne($online
            ? array('path' => $path, 'online' => true)
            : array('path' => $path)
        );
    }

    /**
     * @see SynapseLoaderInterface::retrieveContent()
     */
    public function retrieveContent($contentId)
    {
        return $this->retrieve($contentId);
    }
}
