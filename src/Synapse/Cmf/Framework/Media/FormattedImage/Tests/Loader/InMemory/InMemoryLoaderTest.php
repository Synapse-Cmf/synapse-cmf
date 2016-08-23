<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImageCollection;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for FormattedImage InMemory loader class.
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
            FormattedImageCollection::class,
            $normalizer->reveal()
        );
    }
}
