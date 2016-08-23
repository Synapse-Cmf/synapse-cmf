<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action\Dal;

use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Synapse\Cmf\Framework\Theme\Zone\Domain\DomainInterface as ZoneDomain;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Template creation action representation.
 */
abstract class CreateAction extends AbstractDalAction
{
    /**
     * @var string
     */
    private $templateClass;

    /**
     * @var ZoneDomain
     */
    private $zoneDomain;

    /**
     * @var TemplateTypeInterface
     */
    protected $templateType;

    /**
     * @var ZoneCollection
     */
    protected $zones;

    /**
     * Construct.
     *
     * @param ZoneDomain $zoneDomain
     * @param string     $templateClass
     */
    public function __construct(ZoneDomain $zoneDomain, $templateClass = Template::class)
    {
        $this->zoneDomain = $zoneDomain;
        $this->templateClass = $templateClass;
        $this->zones = new ZoneCollection();
    }

    /**
     * Template object creation method.
     *
     * @param string $templateClass
     *
     * @return TemplateInterface
     */
    abstract protected function createTemplate($templateClass);

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
                $zones->add($this->zoneDomain->create($zoneType));
            }
        }
        $template->setZones($zones);
    }

    /**
     * Template creation method.
     *
     * @return Template
     */
    public function resolve()
    {
        $this->template = $this->createTemplate($this->templateClass);
        $this->template->setZones($this->zones);

        $this->assertEntityIsValid($this->template, array('Template', 'creation'));

        $this->eventDispatcher->addListener(
            TemplateEvents::TEMPLATE_CREATED,
            $handler = array($this, 'onTemplateCreated')
        );
        $this->fireEvent(
            TemplateEvents::TEMPLATE_CREATED,
            new TemplateEvent($this->template, $this)
        );
        $this->eventDispatcher->removeListener(TemplateEvents::TEMPLATE_CREATED, $handler);

        return $this->template;
    }

    /**
     * Define action template type.
     *
     * @param TemplateTypeInterface $templateType
     *
     * @return self
     */
    public function setTemplateType(TemplateTypeInterface $templateType)
    {
        $this->templateType = $templateType;

        return $this;
    }

    /**
     * Define object zones.
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
}
