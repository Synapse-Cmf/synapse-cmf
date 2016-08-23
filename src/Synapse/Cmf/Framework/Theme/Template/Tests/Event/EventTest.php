<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Event;

use Synapse\Cmf\Framework\Theme\Template\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event;

/**
 * Unit test class for Template event class.
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
            $template = new Template(),
            $action
        );

        // Assertions
        $this->assertSame($template, $event->getTemplate());
        $this->assertSame($template, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
