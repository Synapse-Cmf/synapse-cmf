<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Image Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $image = new Image();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($image)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Image')
        );

        $repository->save($image);

        return $repository;
    }

    /**
     * Tests onWriteImage().
     *
     * @depends testSave
     */
    public function testOnWriteImage(DoctrineRepository $repository)
    {
        $repository->onWriteImage(new ImageEvent(
            new Image()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $image = new Image();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($image)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Image')
        );

        $repository->delete($image);

        return $repository;
    }

    /**
     * Tests onDeleteImage().
     *
     * @depends testDelete
     */
    public function testOnDeleteImage(DoctrineRepository $repository)
    {
        $repository->onDeleteImage(new ImageEvent(
            new Image()
        ));
    }
}
