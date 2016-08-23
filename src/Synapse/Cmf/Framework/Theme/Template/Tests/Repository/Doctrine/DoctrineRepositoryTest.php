<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Template Doctrine repository class.
 */
class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $template = new Template();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($template)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Template')
        );

        $repository->save($template);

        return $repository;
    }

    /**
     * Tests onWriteTemplate().
     *
     * @depends testSave
     */
    public function testOnWriteTemplate(DoctrineRepository $repository)
    {
        $repository->onWriteTemplate(new TemplateEvent(
            new Template()
        ));
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $template = new Template();

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($template)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $repository = new DoctrineRepository(
            $em->reveal(),
            new ClassMetadata('Template')
        );

        $repository->delete($template);

        return $repository;
    }

    /**
     * Tests onDeleteTemplate().
     *
     * @depends testDelete
     */
    public function testOnDeleteTemplate(DoctrineRepository $repository)
    {
        $repository->onDeleteTemplate(new TemplateEvent(
            new Template()
        ));
    }
}
