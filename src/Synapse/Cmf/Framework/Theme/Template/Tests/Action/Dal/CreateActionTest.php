<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event;
use Synapse\Cmf\Framework\Theme\Template\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Template CreateAction throught Dal.
 */
class CreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         'incomming data',
     *         'expected_template'
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
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
        array $incommingData,
        Template $expectedTemplate
    ) {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Template::class),
                null,
                array('Template', 'creation')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::TEMPLATE_CREATED,
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
            $expectedTemplate,
            $action->getTemplate()
        );
    }
}
