<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for FormattedImage CreateAction throught Dal.
 */
class CreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         'incomming data',
     *         'expected_formatted_image'
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
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
        array $incommingData,
        FormattedImage $expectedFormattedImage
    ) {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(FormattedImage::class),
                null,
                array('FormattedImage', 'creation')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::FORMATTED_IMAGE_CREATED,
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
            $expectedFormattedImage,
            $action->getFormattedImage()
        );
    }
}
