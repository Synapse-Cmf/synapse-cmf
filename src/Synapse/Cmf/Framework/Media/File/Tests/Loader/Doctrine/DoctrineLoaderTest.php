<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Entity\FileCollection;
use Synapse\Cmf\Framework\Media\File\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Media\File\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for File Doctrine loader class.
 */
class DoctrineLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests class creation.
     */
    public function testConstruct()
    {
        $repository = $this->prophesize(DoctrineRepository::class);
        $repository->save()->shouldNotBeCalled();
        $repository->delete()->shouldNotBeCalled();

        $loader = new DoctrineLoader();
        $loader->setEntityRepository($repository->reveal());
        $loader->configureMetadata(File::class, array('majora' => 'entity'), FileCollection::class);
    }
}
