<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\Image\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event;
use Synapse\Cmf\Framework\Media\Image\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Image DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_image"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new Image())->setId(42),
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
        Image $givenImage
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Image::class),
                null,
                array('Image', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::IMAGE_EDITED,
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
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenImage);

        $action->resolve();
    }
}
