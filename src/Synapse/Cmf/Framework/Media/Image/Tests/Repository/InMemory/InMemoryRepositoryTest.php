<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Repository\InMemory;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Repository\InMemory\InMemoryRepository;

/**
 * Unit test class for Image InMemory repository class.
 */
class InMemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $repository = new InMemoryRepository();
        $repository->save(new Image());
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $repository = new InMemoryRepository();
        $repository->delete(new Image());
    }
}
