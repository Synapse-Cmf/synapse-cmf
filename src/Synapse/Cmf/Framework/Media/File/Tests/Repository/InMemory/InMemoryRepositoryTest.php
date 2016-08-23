<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Repository\InMemory;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Repository\InMemory\InMemoryRepository;

/**
 * Unit test class for File InMemory repository class.
 */
class InMemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $repository = new InMemoryRepository();
        $repository->save(new File());
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $repository = new InMemoryRepository();
        $repository->delete(new File());
    }
}
