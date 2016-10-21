<?php

namespace Synapse\Cmf\Framework\Theme\Content\Tests\Entity;

use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Entity\ContentCollection;

/**
 * Unit test class for Content internal collection class.
 */
class ContentCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getEntityClass() method.
     */
    public function testGetEntityClass()
    {
        $this->assertEquals(
            Content::class,
            (new ContentCollection(array()))->getEntityClass()
        );
    }
}
