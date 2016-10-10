<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Domain;

use Majora\Framework\Domain\Action\ActionFactory;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentType;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\CreateCommand;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\UpdateCommand;
use Synapse\Cmf\Framework\Theme\Component\Domain\ComponentDomain;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;

/**
 * Component command proxy class test.
 */
class ComponentDomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests create() method.
     */
    public function testCreate()
    {
        $componentType = new ComponentType();
        $initialData = array('foo' => 'bar');

        $createCommand = $this->prophesize(CreateCommand::class);
        $createCommand->setComponentType($componentType)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $createCommand->setData($initialData)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $createCommand->resolve()
            ->willReturn($createdComponent = new Component())
            ->shouldBeCalled()
        ;

        $componentDomain = new ComponentDomain(new ActionFactory(array(
            'create' => $createCommand->reveal(),
        )));

        $this->assertEquals(
            $createdComponent,
            $componentDomain->create($componentType, $initialData)
        );
    }

    /**
     * Tests edit() method.
     */
    public function testEdit()
    {
        $component = new Component();
        $component->setData(array('hello' => 'world'));
        $initialData = array('foo' => 'bar');

        $updateCommand = $this->prophesize(UpdateCommand::class);
        $updateCommand->init($component)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $updateCommand->setData($initialData)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $updateCommand->resolve()
            ->shouldBeCalled()
        ;

        $componentDomain = new ComponentDomain(new ActionFactory(array(
            'edit' => $updateCommand->reveal(),
        )));
        $componentDomain->edit($component, $initialData);
    }

    /**
     * Tests delete() method.
     */
    public function testDelete()
    {
        $component = new Component();

        $deleteCommand = $this->prophesize(UpdateCommand::class);
        $deleteCommand->init($component)
            ->will(function ($args, $object) {
                return $object;
            })
            ->shouldBeCalled()
        ;
        $deleteCommand->resolve()
            ->shouldBeCalled()
        ;

        $componentDomain = new ComponentDomain(new ActionFactory(array(
            'delete' => $deleteCommand->reveal(),
        )));
        $componentDomain->delete($component);
    }
}
