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
     * @var string
     */
    protected $frontAssetsPackage;

    /**
     * Construct.
     *
     * @param string $baseLayout
     * @param string $frontAssetsPackage
     */
    public function __construct($baseLayout, $frontAssetsPackage)
    {
        $this->baseLayout = $baseLayout;
        $this->frontAssetsPackage = $frontAssetsPackage;
    }

    /**
     * Returns admin base twig template.
     *
     * @return string
     */
    public function getBaseLayout()
    {
        return $this->baseLayout;
    }

    /**
     * Returns admin assets host.
     *
     * @return string
     */
    public function getFrontAssetsPackage()
    {
        return $this->frontAssetsPackage;
    }
}
