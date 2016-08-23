<?php

namespace Synapse\Cmf\Framework\Media\Video\Domain;

use Synapse\Cmf\Framework\Media\Video\Model\VideoInterface;

/**
 * Interface for Video domain use cases.
 */
interface DomainInterface
{
    /**
     * Create and returns an action for create a Video.
     *
     * @return CreateVideoAction
     */
    public function create();

    /**
     * Create and returns an action for update a Video.
     *
     * @param VideoInterface $video
     *
     * @return UpdateVideoAction
     */
    public function edit(VideoInterface $video);

    /**
     * Create and returns an action for delete a Video.
     *
     * @param VideoInterface $video
     *
     * @return DeleteVideoAction
     */
    public function delete(VideoInterface $video);
}
