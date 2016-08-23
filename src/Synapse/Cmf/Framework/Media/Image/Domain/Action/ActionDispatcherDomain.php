<?php

namespace Synapse\Cmf\Framework\Media\Image\Domain\Action;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\Image\Domain\DomainInterface;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;
use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;

/**
 * Image domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see FileDomainInterface::upload()
     */
    public function upload(PhysicalFile $file, $name = null)
    {
        return $this->getAction('upload')
            ->setName($name)
            ->setSourceFile($file)
            ->resolve()
        ;
    }

    /**
     * @see FileDomainInterface::create()
     */
    public function create(PhysicalFile $file, $name = null)
    {
        return $this->getAction('create')
            ->setName($name)
            ->setPhysicalFile($file)
            ->resolve()
        ;
    }

    /**
     * @see ImageDomainInterface::edit()
     */
    public function edit(ImageInterface $image, ...$arguments)
    {
        return $this->getAction('edit', $image, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see ImageDomainInterface::delete()
     */
    public function delete(ImageInterface $image, ...$arguments)
    {
        return $this->getAction('delete', $image, ...$arguments)
            ->resolve()
        ;
    }
}
