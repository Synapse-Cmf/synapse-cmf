<?php

namespace Synapse\Cmf\Framework\Media\File\Domain\Action;

use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;
use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\File\Domain\DomainInterface;

/**
 * File domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see FileDomainInterface::upload()
     */
    public function upload(PhysicalFile $file)
    {
        return $this->getAction('upload')
            ->setSourceFile($file)
            ->resolve()
        ;
    }

    /**
     * @see FileDomainInterface::create()
     */
    public function create(PhysicalFile $file)
    {
        return $this->getAction('create')
            ->setPhysicalFile($file)
            ->resolve()
        ;
    }
}
