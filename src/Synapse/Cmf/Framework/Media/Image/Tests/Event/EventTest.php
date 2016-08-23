<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Event;

use Synapse\Cmf\Framework\Media\Image\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event;

/**
 * Unit test class for Image event class.
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
            $image = new Image(),
            $action
        );

        // Assertions
        $this->assertSame($image, $event->getImage());
        $this->assertSame($image, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
