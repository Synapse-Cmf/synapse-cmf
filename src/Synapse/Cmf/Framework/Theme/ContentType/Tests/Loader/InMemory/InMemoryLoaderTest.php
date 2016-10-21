<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Tests\Loader\InMemory;

use Majora\Framework\Normalizer\MajoraNormalizer;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentTypeCollection;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\InMemory\InMemoryLoader;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Unit test class for ContentType InMemory loader class.
 */
class InMemoryLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests retrieveByContentClass() method.
     */
    public function testRetrieveByContentClass()
    {
        $normalizer = $this->prophesize(MajoraNormalizer::class);
        $normalizer->normalize()->shouldNotBeCalled();

        $loader = new InMemoryLoader(ContentTypeCollection::class, $normalizer->reveal());
        $loader->registerEntity((new ContentType())->setId('A')->setContentClass(ContentA::class));
        $loader->registerEntity($ctypeB = (new ContentType())->setId('B')->setContentClass(ContentB::class));
        $loader->registerEntity($ctypeC = (new ContentType())->setId('C')->setContentClass(ContentC::class));

        $contentTypes = $loader->retrieveByContentClass(ContentB::class)->toArray();
        $this->assertEquals(
            array('B' => $ctypeB, 'C' => $ctypeC),
            $contentTypes
        );
    }
}

class ContentA implements ContentInterface
{
    public function getContentId()
    {
        return 'A';
    }
}
class ContentB extends ContentA
{
    public function getContentId()
    {
        return 'B';
    }
}
class ContentC extends ContentB
{
    public function getContentId()
    {
        return 'C';
    }
}
