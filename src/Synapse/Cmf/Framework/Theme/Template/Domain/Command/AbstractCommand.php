<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Majora\Framework\Domain\Action\ActionInterface;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Domain\DomainInterface as ZoneDomain;
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
     * @var ZoneDomain
     */
    protected $zoneDomain;

    /**
     * Template creation event handler.
     *
     * @param TemplateEvent $event
     */
    public function onTemplateCreated(TemplateEvent $event)
    {
        $template = $event->getTemplate();
        $zones = $template->getZones();
        foreach ($template->getTemplateType()->getZoneTypes() as $zoneType) {
            if ($zones->search(array('zoneType' => $zoneType))->isEmpty()) {
                if (null === $this->zoneDomain) {
                    throw new \DomainException('No zoneDomain was set, you are unable to update your configuration.');
                }

                $zones->add($this->zoneDomain->create($zoneType));
            }
        }
        $template->setZones($zones);
    }

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

    /**
     * Set zoneDomain.
     *
     * @param ZoneDomain $zoneDomain
     */
    public function setZoneDomain(ZoneDomain $zoneDomain)
    {
        $this->zoneDomain = $zoneDomain;
    }
}
