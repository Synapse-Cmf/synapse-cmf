<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event;
use Synapse\Cmf\Framework\Theme\Component\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for Component DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_component"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
                new Component(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        Component $givenComponent
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::COMPONENT_DELETED,
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
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenComponent);

        $action->resolve();
    }
}
