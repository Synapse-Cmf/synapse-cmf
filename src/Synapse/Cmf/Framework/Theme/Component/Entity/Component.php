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
     * Returns Component id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Component id.
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
     * Returns Component component type.
     *
     * @return ComponentTypeInterface
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * Define Component component type.
     *
     * @param ComponentTypeInterface $componentType
     *
     * @return self
     */
    public function setComponentType(ComponentTypeInterface $componentType)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * Returns Component all data or for given key.
     *
     * @param string $key     optionnal data key to read
     * @param mixed  $default optionnal default value if key is missing
     *
     * @return array|mixed
     */
    public function getData($key = null, $default = null)
    {
        if (!$key) {
            return $this->data;
        }

        return $key && isset($this->data[$key])
            ? $this->data[$key]
            : $default
        ;
    }

    /**
     * Define Component data.
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Returns Component ranking.
     *
     * @return int
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Define Component ranking.
     *
     * @param int $ranking
     *
     * @return self
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }
}
