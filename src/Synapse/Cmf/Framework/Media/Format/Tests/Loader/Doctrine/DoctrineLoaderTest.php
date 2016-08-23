<?php

namespace Synapse\Cmf\Framework\Media\Format\Tests\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\Format\Entity\Format;
use Synapse\Cmf\Framework\Media\Format\Entity\FormatCollection;
use Synapse\Cmf\Framework\Media\Format\Loader\Doctrine\DoctrineLoader;
use Synapse\Cmf\Framework\Media\Format\Repository\Doctrine\DoctrineRepository;

/**
 * Unit test class for Format Doctrine loader class.
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
            Format::class,
            array('majora' => 'entity'),
            FormatCollection::class,
            $repository->reveal()
        );
    }
}
