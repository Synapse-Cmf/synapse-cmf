<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Tests\Loader\InMemory;

use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateTypeCollection;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\InMemory\InMemoryLoader;
use Majora\Framework\Normalizer\MajoraNormalizer;

/**
 * Unit test class for TemplateType InMemory loader class.
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
            TemplateTypeCollection::class,
            $normalizer->reveal()
        );
    }
}
