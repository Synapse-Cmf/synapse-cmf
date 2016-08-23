<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Loader\Doctrine;

use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\LoaderInterface;

/**
 * FormattedImage loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;

    /**
     * @see LoaderInterface::retrieveByFile()
     */
    public function retrieveByFile(FileInterface $file)
    {
        return $this
            ->createQuery('image')
                ->innerJoin('image.file', 'file')
                ->where('file.storePath = :storePath')
                    ->setParameter(':storePath', $file->getStorePath())
                ->andWhere('file.name = :name')
                    ->setParameter(':name', $file->getName())
            ->getQuery()
                ->getOneOrNullResult()
        ;
    }
}
