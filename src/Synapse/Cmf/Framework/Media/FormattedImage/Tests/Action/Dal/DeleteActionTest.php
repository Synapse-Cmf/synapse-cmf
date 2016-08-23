<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for FormattedImage DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_formatted_image"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
                new FormattedImage(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        FormattedImage $givenFormattedImage
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::FORMATTED_IMAGE_DELETED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenFormattedImage) {
                $asserter->assertEquals(
                    $givenFormattedImage,
                    $args[1]->getFormattedImage()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenFormattedImage);

        $action->resolve();
    }
}
