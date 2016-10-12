<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain\Command;

use Majora\Framework\Domain\Action\ActionInterface;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Base class for Zone commands.
 */
abstract class AbstractCommand implements ActionInterface
{
    use DalActionTrait;

    /**
     * @var ZoneInterface
     */
    protected $zone;

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
