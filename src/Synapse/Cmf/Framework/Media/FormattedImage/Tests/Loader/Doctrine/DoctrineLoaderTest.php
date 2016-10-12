<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImageCollection;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Media\FormattedImage\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for FormattedImage Doctrine loader class.
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
        $loader->configureMetadata(FormattedImage::class, array('majora' => 'entity'), FormattedImageCollection::class);
    }
}
