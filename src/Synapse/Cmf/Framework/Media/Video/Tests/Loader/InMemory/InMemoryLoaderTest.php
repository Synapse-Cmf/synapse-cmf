<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Video\Entity\VideoCollection;
use Synapse\Cmf\Framework\Media\Video\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for Video InMemory loader class.
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
            VideoCollection::class,
            $normalizer->reveal()
        );
    }
}
