<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Domain\Action;

use Synapse\Cmf\Framework\Theme\Template\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Template\Domain\Action\ActionDispatcherDomain;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Majora\Framework\Domain\Action\ActionFactory;

/**
 * Unit test class for ActionDispatcher Template domain implementation.
 */
class ActionDispatcherDomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests create() method.
     */
    public function testCreate()
    {
        $action = $this->prophesize(AbstractAction::class);
        $action->denormalize(array('cortex' => 'swiffer'))
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->init(null, array('cortex' => 'swiffer'), 'synapse')
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->resolve()
            ->willReturn($createdEntity = new Template())
            ->shouldBeCalled()
        ;

        $domain = new ActionDispatcherDomain(new ActionFactory(array(
            'create' => $action->reveal(),
        )));

        $entity = $domain->create(
            array('cortex' => 'swiffer'),
            'synapse'
        );

        $this->assertSame($createdEntity, $entity);
    }

    /**
     * Tests edit() method.
     */
    public function testEdit()
    {
        $entity = new Template();

        $action = $this->prophesize(AbstractAction::class);
        $action->denormalize(array('cortex' => 'swiffer'))
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->init($entity, array('cortex' => 'swiffer'), 'synapse')
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->resolve()->shouldBeCalled();

        $domain = new ActionDispatcherDomain(new ActionFactory(array(
            'edit' => $action->reveal(),
        )));

        $domain->edit(
            $entity,
            array('cortex' => 'swiffer'),
            'synapse'
        );
    }

    /**
     * Tests delete() method.
     */
    public function testDelete()
    {
        $entity = new Template();

        $action = $this->prophesize(AbstractAction::class);
        $action->denormalize(array('cortex' => 'swiffer'))
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->init($entity, array('cortex' => 'swiffer'), 'synapse')
            ->will(function ($args, $self) {
                return $self;
            })
            ->shouldBeCalled()
        ;
        $action->resolve()->shouldBeCalled();

        $domain = new ActionDispatcherDomain(new ActionFactory(array(
            'delete' => $action->reveal(),
        )));

        $domain->delete(
            $entity,
            array('cortex' => 'swiffer'),
            'synapse'
        );
    }
}
