<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Template creation command representation.
 */
abstract class CreateCommand extends AbstractCommand
{
    /**
     * @var string
     */
    private $templateClass;

    /**
     * @var TemplateTypeInterface
     */
    protected $templateType;

    /**
     * Construct.
     *
     * @param string $templateClass
     */
    public function __construct($templateClass = Template::class)
    {
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
}
