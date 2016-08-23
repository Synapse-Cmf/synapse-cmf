<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Theme\Theme\Entity\ThemeCollection;
use Synapse\Cmf\Framework\Theme\Theme\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for Theme InMemory loader class.
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
            ThemeCollection::class,
            $normalizer->reveal()
        );
    }
}
