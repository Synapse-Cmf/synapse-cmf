<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Tests\Loader\InMemory;

use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentTypeCollection;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\InMemory\InMemoryLoader;

/**
 * Unit test class for ComponentType InMemory loader class.
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
            ComponentTypeCollection::class,
            $normalizer->reveal()
        );
    }
}
