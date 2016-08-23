<?php

namespace Synapse\Admin\Bundle\Twig\Extension;

use Synapse\Admin\Bundle\SynapseAdmin;

/**
 * Admin twig extension which provide synapse admin vars.
 */
class AdminExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var SynapseAdmin
     */
    protected $synapseAdmin;

    /**
     * Construct.
     *
     * @param SynapseAdmin $synapseAdmin
     */
    public function __construct(SynapseAdmin $synapseAdmin)
    {
        $this->synapseAdmin = $synapseAdmin;
    }

    /**
     * @see \Twig_Extension::getName()
     */
    public function getName()
    {
        return 'synapse_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array('synapse' => array('admin' => array(
            'base_layout' => $this->synapseAdmin->getBaseLayout(),
        )));
    }
}
