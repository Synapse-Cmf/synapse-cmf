<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event;
use Synapse\Cmf\Framework\Theme\Template\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Template DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_template"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new Template())->setId(42),
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
        Template $givenTemplate
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Template::class),
                null,
                array('Template', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::TEMPLATE_EDITED,
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
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenTemplate);

        $action->resolve();
    }
}
