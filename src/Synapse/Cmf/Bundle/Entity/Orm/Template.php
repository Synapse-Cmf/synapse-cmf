<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template as SynapseTemplate;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection as SynapseZoneCollection;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Synapse template specific Orm implementation.
 */
class Template extends SynapseTemplate implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * @var string
     */
    protected $contentTypeName;

    /**
     * @var int
     */
    protected $contentId;

    /**
     * @var string
     */
    protected $templateTypeId;

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setContent(Content $content)
    {
        $this->contentTypeName = $content->getType()->getName();
        $this->contentId = $content->getContentId();

        return parent::setContent($content);
    }

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return $this->load('contentType');
    }

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentTypeName = $contentType->getName();
        $this->contentTypeId = null;

        return parent::setContentType($contentType);
    }

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getTemplateType()
    {
        return $this->load('templateType');
    }

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setTemplateType(TemplateTypeInterface $templateType)
    {
        $this->templateTypeId = $templateType->getId();

        return parent::setTemplateType($templateType);
    }

    /**
     * Doctrine doesnt hydrate custom collections when loaded
     * so we use collectionnableTrait to always cast ZoneCollection.
     *
     * {@inheritdoc}
     */
    public function getZones()
    {
        return $this->zones = $this->toCollection(
            $this->zones,
            SynapseZoneCollection::class
        );
    }

    /**
     * Doctrine needs to cross reference fks.
     *
     * {@inheritdoc}
     */
    public function setZones(ZoneCollection $components)
    {
        return parent::setZones($components->map(function (Zone $zone) {
            return $zone->setTemplate($this);
        }));
    }

    /**
     * Returns object template type id.
     *
     * @return string
     */
    public function getTemplateTypeId()
    {
        return $this->templateTypeId;
    }

    /**
     * Returns object content type name.
     *
     * @return string
     */
    public function getContentTypeName()
    {
        return $this->contentTypeName;
    }
}
