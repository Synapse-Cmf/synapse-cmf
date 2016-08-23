<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Event;

use Synapse\Cmf\Framework\Theme\Component\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;

/**
 * Unit test class for Component event class.
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
            $component = new Component(),
            $action
        );

        // Assertions
        $this->assertSame($component, $event->getComponent());
        $this->assertSame($component, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
