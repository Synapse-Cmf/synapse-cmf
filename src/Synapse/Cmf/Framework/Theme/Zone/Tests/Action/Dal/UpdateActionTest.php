<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Zone\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Zone DeleteAction throught Dal.
 */
class UpdateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_update_data",
     *         "given_zone"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                (new Zone())->setId(42),
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
        Zone $givenZone
    ) {
        $asserter = $this;

        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Zone::class),
                null,
                array('Zone', 'edition')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::ZONE_EDITED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenZone) {
                $asserter->assertEquals(
                    $givenZone,
                    $args[1]->getZone()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new UpdateAction();
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenZone);

        $action->resolve();
    }
}
