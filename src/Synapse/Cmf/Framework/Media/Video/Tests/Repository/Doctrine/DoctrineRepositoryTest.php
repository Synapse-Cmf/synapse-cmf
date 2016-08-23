<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event as VideoEvent;
use Synapse\Cmf\Framework\Media\Video\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Video Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $video = new Video();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($video)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Video')
        );

        $repository->save($video);

        return $repository;
    }

    /**
     * Tests onWriteVideo().
     *
     * @depends testSave
     */
    public function testOnWriteVideo(DoctrineRepository $repository)
    {
        $repository->onWriteVideo(new VideoEvent(
            new Video()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $video = new Video();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($video)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Video')
        );

        $repository->delete($video);

        return $repository;
    }

    /**
     * Tests onDeleteVideo().
     *
     * @depends testDelete
     */
    public function testOnDeleteVideo(DoctrineRepository $repository)
    {
        $repository->onDeleteVideo(new VideoEvent(
            new Video()
        ));
    }
}
