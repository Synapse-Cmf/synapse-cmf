<?php

namespace Synapse\Admin\Bundle;

/**
 * Value object class, supports of Synapse admin configurations.
 */
class SynapseAdmin
{
    /**
     * @var string
     */
    protected $baseLayout;

    /**
     * Construct.
     *
     * @param string $baseLayout
     */
    public function __construct($baseLayout)
    {
        $this->baseLayout = $baseLayout;
    }

    /**
     * Returns object base twig template.
     *
     * @return string
     */
    public function getBaseLayout()
    {
        return $this->baseLayout;
    }
}
