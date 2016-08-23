<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event;
use Synapse\Cmf\Framework\Media\Video\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Video DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_video"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new Video())->setId(42),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        array $incommingData,
        Video $givenVideo
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Video::class),
                null,
                array('Video', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::VIDEO_EDITED,
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
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenVideo);

        $action->resolve();
    }
}
