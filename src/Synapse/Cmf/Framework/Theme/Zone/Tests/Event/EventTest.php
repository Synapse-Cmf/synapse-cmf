<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Event;

use Synapse\Cmf\Framework\Theme\Zone\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;

/**
 * Unit test class for Zone event class.
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() function.
     */
    public function testAccessors()
    {
        $action = $this->prophesize(AbstractAction::class)->reveal();

        // Event
        $event = new Event(
            $zone = new Zone(),
            $action
        );

        // Assertions
        $this->assertSame($zone, $event->getZone());
        $this->assertSame($zone, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
