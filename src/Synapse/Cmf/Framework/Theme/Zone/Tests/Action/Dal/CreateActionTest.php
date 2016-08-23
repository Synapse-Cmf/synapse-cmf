<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Action\Dal;

use Synapse\Cmf\Framework\Theme\Zone\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for Zone CreateAction throught Dal.
 */
class CreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         'incomming data',
     *         'expected_zone'
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                new Zone(),
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
        Zone $expectedZone
    ) {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(Zone::class),
                null,
                array('Zone', 'creation')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::ZONE_CREATED,
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
            $expectedZone,
            $action->getZone()
        );
    }
}
