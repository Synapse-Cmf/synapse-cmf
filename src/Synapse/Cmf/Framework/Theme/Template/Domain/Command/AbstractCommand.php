<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Majora\Framework\Domain\Action\ActionInterface;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Base class for Template commands.
 */
abstract class AbstractCommand implements ActionInterface
{
    use DalActionTrait;

    /**
     * @var TemplateInterface
     */
    protected $template;

    /**
     * @var ZoneCollection
     */
    protected $zones;

    /**
     * Return related Template if defined.
     *
     * @return TemplateInterface $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Define Command zones.
     *
     * @param ZoneCollection $zones
     *
     * @return self
     */
    public function setZones(ZoneCollection $zones)
    {
        $this->zones = $zones;

        return $this;
    }

    /**
     * Returns Command zones.
     *
     * @return ZoneCollection
     */
    public function getZones()
    {
        return $this->zones;
    }
}
