<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Event;

use Synapse\Cmf\Framework\Media\Video\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event;

/**
 * Unit test class for Video event class.
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
            $video = new Video(),
            $action
        );

        // Assertions
        $this->assertSame($video, $event->getVideo());
        $this->assertSame($video, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
