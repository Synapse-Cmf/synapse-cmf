<?php

namespace Synapse\Cmf\Framework\Theme\Component\Model;

use Majora\Framework\Model\CollectionableInterface;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;

/**
 * Interface for Component entities use cases.
 */
interface ComponentInterface extends CollectionableInterface
{
    /**
     * Returns Component component type.
     *
     * @return ComponentTypeInterface
     */
    public function getComponentType();

    /**
     * Define Component component type.
     *
     * @param ComponentTypeInterface $componentType
     *
     * @return self
     */
    public function setComponentType(ComponentTypeInterface $componentType);

    /**
     * Returns Component all data or for given key.
     *
     * @param string $key     optionnal data key to read
     * @param mixed  $default optionnal default value if key is missing
     *
     * @return array|mixed
     */
    public function getData($key = null, $default = null);

    /**
     * Define Component data.
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data);

    /**
     * Returns Component ranking.
     *
     * @return int
     */
    public function getRanking();

    /**
     * Define Component ranking.
     *
     * @param int $ranking
     *
     * @return self
     */
    public function setRanking($ranking);
}
