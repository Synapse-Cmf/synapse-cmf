<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;

/**
 * ComponentType entity class.
 */
class ComponentType implements ComponentTypeInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $labels;

    /**
     * @var string
     */
    protected $formType;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @var array
     */
    protected $config;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id', 'name', 'form_type', 'controller'),
            'full' => array('@default', 'labels'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->config = array();
    }

    /**
     * Returns ComponentType id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define ComponentType id.
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
     * Returns ComponentType name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define ComponentType name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns ComponentType labels.
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Returns ComponentType form type.
     *
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Returns ComponentType controller.
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns ComponentType template path.
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Returns ComponentType config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Define object labels.
     *
     * @param array $labels
     *
     * @return self
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Define object form type.
     *
     * @param string $formType
     *
     * @return self
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;

        return $this;
    }

    /**
     * Define object controller.
     *
     * @param string $controller
     *
     * @return self
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Define object template path.
     *
     * @param string $templatePath
     *
     * @return self
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }

    /**
     * Define object config.
     *
     * @param array $config
     *
     * @return self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}
