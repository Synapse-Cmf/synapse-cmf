<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Component Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $component = new Component();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($component)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Component')
        );

        $repository->save($component);

        return $repository;
    }

    /**
     * Tests onWriteComponent().
     *
     * @depends testSave
     */
    public function testOnWriteComponent(DoctrineRepository $repository)
    {
        $repository->onWriteComponent(new ComponentEvent(
            new Component()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $component = new Component();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($component)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Component')
        );

        $repository->delete($component);

        return $repository;
    }

    /**
     * Tests onDeleteComponent().
     *
     * @depends testDelete
     */
    public function testOnDeleteComponent(DoctrineRepository $repository)
    {
        $repository->onDeleteComponent(new ComponentEvent(
            new Component()
        ));
    }
}
