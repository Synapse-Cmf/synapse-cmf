<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneTypeCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for ZoneType InMemory loader class.
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
            ZoneTypeCollection::class,
            $normalizer->reveal()
        );
    }
}
