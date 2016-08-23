<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event;
use Synapse\Cmf\Framework\Media\Video\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for Video DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_video"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
                new Video(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        Video $givenVideo
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::VIDEO_DELETED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenVideo) {
                $asserter->assertEquals(
                    $givenVideo,
                    $args[1]->getVideo()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenVideo);

        $action->resolve();
    }
}
