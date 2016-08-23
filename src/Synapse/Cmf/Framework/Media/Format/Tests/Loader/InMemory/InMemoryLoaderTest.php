<?php

namespace Synapse\Cmf\Framework\Media\Format\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Format\Entity\FormatCollection;
use Synapse\Cmf\Framework\Media\Format\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for Format InMemory loader class.
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
            FormatCollection::class,
            $normalizer->reveal()
        );
    }
}
