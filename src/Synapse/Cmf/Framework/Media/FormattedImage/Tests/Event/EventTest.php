<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Event;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event;

/**
 * Unit test class for FormattedImage event class.
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
            $formattedImage = new FormattedImage(),
            $action
        );

        // Assertions
        $this->assertSame($formattedImage, $event->getFormattedImage());
        $this->assertSame($formattedImage, $event->getSubject());
        $this->assertSame($action, $event->getAction());
    }
}
