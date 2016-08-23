<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for FormattedImage DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_formatted_image"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new FormattedImage())->setId(42),
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
        FormattedImage $givenFormattedImage
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(FormattedImage::class),
                null,
                array('FormattedImage', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::FORMATTED_IMAGE_EDITED,
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
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenFormattedImage);

        $action->resolve();
    }
}
