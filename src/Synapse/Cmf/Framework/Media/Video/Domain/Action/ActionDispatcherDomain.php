<?php

namespace Synapse\Cmf\Framework\Media\Video\Domain\Action;

use Synapse\Cmf\Framework\Media\Video\Domain\DomainInterface;
use Synapse\Cmf\Framework\Media\Video\Model\VideoInterface;
use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;

/**
 * Video domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see VideoDomainInterface::create()
     */
    public function create(...$arguments)
    {
        return $this->getAction('create', null, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see VideoDomainInterface::edit()
     */
    public function edit(VideoInterface $video, ...$arguments)
    {
        return $this->getAction('edit', $video, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see VideoDomainInterface::delete()
     */
    public function delete(VideoInterface $video, ...$arguments)
    {
        return $this->getAction('delete', $video, ...$arguments)
            ->resolve()
        ;
    }
}
