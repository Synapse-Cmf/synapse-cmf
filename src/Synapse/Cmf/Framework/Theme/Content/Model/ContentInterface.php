<?php

namespace Synapse\Cmf\Framework\Theme\Content\Model;

/**
 * Interface defining contents behaviors, implement it into custom content classes.
 */
interface ContentInterface
{
    /**
     * Returns an unique content identifier for this object.
     *
     * @return scalar
     */
    public function getContentId();
}
