<?php

namespace Synapse\Cmf\Framework\Theme\Component\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component entity class.
 */
class Component implements ComponentInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var ComponentTypeInterface
     */
    protected $componentType;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $ranking = 99;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id'),
            'template' => array('@default'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->data = array();
    }

    /**
     * @see ComponentInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @see ComponentInterface::setId()
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @see ComponentInterface::getComponentType()
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * @see ComponentInterface::setComponentType()
     */
    public function setComponentType(ComponentTypeInterface $componentType)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * @see ComponentInterface::getData()
     */
    public function getData($key = null, $default = null)
    {
        if (!$key) {
            return $this->data;
        }

        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * @see ComponentInterface::setData()
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @see ComponentInterface::getRanking()
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * @see ComponentInterface::setRanking()
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }
}
