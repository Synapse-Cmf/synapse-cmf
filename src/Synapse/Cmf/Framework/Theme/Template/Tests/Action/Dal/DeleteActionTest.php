<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event;
use Synapse\Cmf\Framework\Theme\Template\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for Template DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_template"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
                new Template(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        Template $givenTemplate
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::TEMPLATE_DELETED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenTemplate) {
                $asserter->assertEquals(
                    $givenTemplate,
                    $args[1]->getTemplate()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenTemplate);

        $action->resolve();
    }
}
