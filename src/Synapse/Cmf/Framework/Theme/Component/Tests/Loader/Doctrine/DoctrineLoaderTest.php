<?php

namespace Synapse\Cmf\Framework\Theme\Component\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Component\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Theme\Component\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Component Doctrine loader class.
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
        $loader->configureMetadata(Component::class, array('majora' => 'entity'), ComponentCollection::class);
    }
}
