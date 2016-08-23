<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event as FileEvent;
use Synapse\Cmf\Framework\Media\File\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for File Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $file = new File();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($file)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('File')
        );

        $repository->save($file);

        return $repository;
    }

    /**
     * Tests onWriteFile().
     *
     * @depends testSave
     */
    public function testOnWriteFile(DoctrineRepository $repository)
    {
        $repository->onWriteFile(new FileEvent(
            new File()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $file = new File();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($file)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('File')
        );

        $repository->delete($file);

        return $repository;
    }

    /**
     * Tests onDeleteFile().
     *
     * @depends testDelete
     */
    public function testOnDeleteFile(DoctrineRepository $repository)
    {
        $repository->onDeleteFile(new FileEvent(
            new File()
        ));
    }
}
