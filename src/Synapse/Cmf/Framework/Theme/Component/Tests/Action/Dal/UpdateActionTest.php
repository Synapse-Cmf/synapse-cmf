<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;
use Synapse\Cmf\Framework\Theme\Component\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Component DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_component"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new Component())->setId(42),
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
        Component $givenComponent
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Component::class),
                null,
                array('Component', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::COMPONENT_EDITED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenComponent) {
                $asserter->assertEquals(
                    $givenComponent,
                    $args[1]->getComponent()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenComponent);

        $action->resolve();
    }
}
