<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Event;

use Synapse\Cmf\Framework\Theme\Template\Domain\Command\AbstractCommand;
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
        // Event
        $event = new Event(
            $template = new Template(),
            $command = $this->prophesize(AbstractCommand::class)->reveal()
        );

        // Assertions
        $this->assertSame($template, $event->getTemplate());
        $this->assertSame($template, $event->getSubject());
        $this->assertSame($command, $event->getAction());
    }
}
