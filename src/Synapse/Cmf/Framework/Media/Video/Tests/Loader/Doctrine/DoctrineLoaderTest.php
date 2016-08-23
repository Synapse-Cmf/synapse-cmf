<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Entity\VideoCollection;
use Synapse\Cmf\Framework\Media\Video\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Media\Video\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Video Doctrine loader class.
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
        $loader->setUp(
            Video::class,
            array('majora' => 'entity'),
            VideoCollection::class,
            $repository->reveal()
        );
    }
}
