<?php

namespace Synapse\Cmf\Framework\Theme\Template\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Template entity class.
 */
class Template implements TemplateInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * Enum : local or global.
     *
     * @var string
     */
    protected $scope;

    /**
     * @var TemplateTypeInterface
     */
    protected $templateType;

    /**
     * @var Content
     */
    protected $content;

    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @var TemplateInterface
     */
    protected $globalTemplate;

    /**
     * @var ZoneCollection
     */
    protected $zones;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->zones = new ZoneCollection();
    }

    /**
     * Returns Template id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Template id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns Template zones.
     *
     * @return ZoneCollection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Define Template zones.
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
     * Returns Template template type.
     *
     * @return TemplateTypeInterface
     */
    public function getTemplateType()
    {
        return $this->templateType;
    }

    /**
     * Define Template template type.
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
     * Returns Template content.
     *
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Define Template content.
     *
     * @param Content $content
     *
     * @return self
     */
    public function setContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns Template content type.
     *
     * @return ContentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Define Template content type.
     *
     * @param ContentType $contentType
     *
     * @return self
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Define template as a global one.
     *
     * @return self
     */
    public function setGlobal()
    {
        return $this->setScope(TemplateInterface::GLOBAL_SCOPE);
    }

    /**
     * Define template as a local one.
     *
     * @return self
     */
    public function setLocal()
    {
        return $this->setScope(TemplateInterface::LOCAL_SCOPE);
    }

    /**
     * Returns Template scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Define Template scope.
     *
     * @param string $scope
     *
     * @return self
     */
    protected function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Returns Template global related template.
     *
     * @return TemplateInterface
     */
    public function getGlobalTemplate()
    {
        return $this->globalTemplate;
    }

    /**
     * Define Template global related template.
     *
     * @param TemplateInterface $globalTemplate
     *
     * @return self
     */
    public function setGlobalTemplate(TemplateInterface $globalTemplate)
    {
        $this->globalTemplate = $globalTemplate;

        return $this;
    }
}
