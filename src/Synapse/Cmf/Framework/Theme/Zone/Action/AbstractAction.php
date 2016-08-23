<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action;

use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Base class for Zone Actions.
 *
 * @property $zone
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var ZoneInterface
     */
    protected $zone;

    /**
     * Initialisation function.
     *
     * @param ZoneInterface $zone
     */
    public function init(ZoneInterface $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Return related Zone if defined.
     *
     * @return ZoneInterface|null $zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Rank given component collection.
     *
     * @param ComponentCollection $components
     *
     * @return ComponentCollection
     */
    protected function rankComponents(ComponentCollection $components)
    {
        $i = 0;

        return $components->map(function (ComponentInterface $component) use (&$i) {
            return $component->setRanking(++$i);
        });
    }
}
