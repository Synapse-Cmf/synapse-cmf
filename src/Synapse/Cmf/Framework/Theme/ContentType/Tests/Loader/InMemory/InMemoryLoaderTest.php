<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentTypeCollection;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for ContentType InMemory loader class.
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
            ContentTypeCollection::class,
            $normalizer->reveal()
        );
    }
}
