<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Media\File\Entity\FileCollection;
use Synapse\Cmf\Framework\Media\File\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for File InMemory loader class.
 */
class InMemoryLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests class creation.
     */
    public function testConstruct()
    {
        $normalizer = $this->prophesize(MajoraNormalizer::class);
        $normalizer->normalize()->shouldNotBeCalled();

        new InMemoryLoader(
            FileCollection::class,
            $normalizer->reveal()
        );
    }
}
