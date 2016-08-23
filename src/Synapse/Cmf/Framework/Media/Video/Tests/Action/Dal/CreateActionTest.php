<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event;
use Synapse\Cmf\Framework\Media\Video\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Video CreateAction throught Dal.
 */
class CreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         'incomming data',
     *         'expected_video'
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
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
        array $incommingData,
        Video $expectedVideo
    ) {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Video::class),
                null,
                array('Video', 'creation')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::VIDEO_CREATED,
                Argument::type(Event::class)
            )
            ->shouldBeCalled()
        ;

        // Action
        $action = new CreateAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->resolve();

        $this->assertEquals(
            $expectedVideo,
            $action->getVideo()
        );
    }
}
