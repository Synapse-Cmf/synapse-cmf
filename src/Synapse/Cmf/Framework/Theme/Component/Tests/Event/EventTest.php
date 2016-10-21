<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Event;

use Synapse\Cmf\Framework\Theme\Component\Domain\Command\AbstractCommand;
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
        $action = $this->prophesize(AbstractCommand::class)->reveal();

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
