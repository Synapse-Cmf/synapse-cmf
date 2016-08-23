<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\Image\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event;
use Synapse\Cmf\Framework\Media\Image\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for Image DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_image"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
                new Image(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        Image $givenImage
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::IMAGE_DELETED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenImage) {
                $asserter->assertEquals(
                    $givenImage,
                    $args[1]->getImage()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenImage);

        $action->resolve();
    }
}
