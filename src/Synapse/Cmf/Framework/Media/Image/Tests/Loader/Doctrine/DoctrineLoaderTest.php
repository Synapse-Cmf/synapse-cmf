<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Entity\ImageCollection;
use Synapse\Cmf\Framework\Media\Image\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Media\Image\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Image Doctrine loader class.
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
        $loader->configureMetadata(Image::class, array('majora' => 'entity'), ImageCollection::class);
    }
}
