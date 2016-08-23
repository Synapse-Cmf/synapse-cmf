<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Zone Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $zone = new Zone();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($zone)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Zone')
        );

        $repository->save($zone);

        return $repository;
    }

    /**
     * Tests onWriteZone().
     *
     * @depends testSave
     */
    public function testOnWriteZone(DoctrineRepository $repository)
    {
        $repository->onWriteZone(new ZoneEvent(
            new Zone()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $zone = new Zone();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($zone)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Zone')
        );

        $repository->delete($zone);

        return $repository;
    }

    /**
     * Tests onDeleteZone().
     *
     * @depends testDelete
     */
    public function testOnDeleteZone(DoctrineRepository $repository)
    {
        $repository->onDeleteZone(new ZoneEvent(
            new Zone()
        ));
    }
}
