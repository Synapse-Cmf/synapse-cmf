<?php

namespace Synapse\Cmf\Framework\Engine\Bridge\Twig;

use Synapse\Cmf\Framework\Engine\Renderer\Zone\ZoneRenderer;

/**
 * Extension class which provides Synapse specific tags :
 *   - {{ synapse_zone('name') }}.
 */
class Extension extends \Twig_Extension
{
    /**
     * @var ZoneRenderer
     */
    protected $zoneRenderer;

    /**
     * Construct.
     *
     * @param ZoneRenderer $zoneRenderer
     */
    public function __construct(ZoneRenderer $zoneRenderer)
    {
        $this->zoneRenderer = $zoneRenderer;
    }

    /**
     * @see \Twig_Extension::getName()
     */
    public function getName()
    {
        return 'synapse';
    }

    /**
     * @see \Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('synapse_zone', array($this, 'renderZone'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Render zone under given name.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    public function renderZone($name, array $parameters = array())
    {
        return $this->zoneRenderer->render($name, $parameters);
    }
}
