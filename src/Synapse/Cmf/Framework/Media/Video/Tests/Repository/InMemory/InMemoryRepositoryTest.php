<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Repository\InMemory;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Repository\InMemory\InMemoryRepository;

/**
 * Unit test class for Video InMemory repository class.
 */
class InMemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $repository = new InMemoryRepository();
        $repository->save(new Video());
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $repository = new InMemoryRepository();
        $repository->delete(new Video());
    }
}
