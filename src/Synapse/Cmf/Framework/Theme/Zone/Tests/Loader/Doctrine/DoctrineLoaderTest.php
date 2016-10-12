<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;
use Synapse\Cmf\Framework\Theme\Zone\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Theme\Zone\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Zone Doctrine loader class.
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
        $loader->configureMetadata(Zone::class, array('majora' => 'entity'), ZoneCollection::class);
    }
}
