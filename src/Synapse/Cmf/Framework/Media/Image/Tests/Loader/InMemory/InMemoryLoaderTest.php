<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Image\Entity\ImageCollection;
use Synapse\Cmf\Framework\Media\Image\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for Image InMemory loader class.
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
            ImageCollection::class,
            $normalizer->reveal()
        );
    }
}
