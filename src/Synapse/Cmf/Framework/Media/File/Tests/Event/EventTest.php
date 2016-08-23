<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Event;

use Synapse\Cmf\Framework\Media\File\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event;

/**
 * Unit test class for File event class.
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
            $file = new File(),
            $action
        );

        // Assertions
        $this->assertSame($file, $event->getFile());
        $this->assertSame($file, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
