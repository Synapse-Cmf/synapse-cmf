<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event as FormattedImageEvent;
use Synapse\Cmf\Framework\Media\FormattedImage\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for FormattedImage Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $formattedImage = new FormattedImage();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($formattedImage)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('FormattedImage')
        );

        $repository->save($formattedImage);

        return $repository;
    }

    /**
     * Tests onWriteFormattedImage().
     *
     * @depends testSave
     */
    public function testOnWriteFormattedImage(DoctrineRepository $repository)
    {
        $repository->onWriteFormattedImage(new FormattedImageEvent(
            new FormattedImage()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $formattedImage = new FormattedImage();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($formattedImage)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('FormattedImage')
        );

        $repository->delete($formattedImage);

        return $repository;
    }

    /**
     * Tests onDeleteFormattedImage().
     *
     * @depends testDelete
     */
    public function testOnDeleteFormattedImage(DoctrineRepository $repository)
    {
        $repository->onDeleteFormattedImage(new FormattedImageEvent(
            new FormattedImage()
        ));
    }
}
