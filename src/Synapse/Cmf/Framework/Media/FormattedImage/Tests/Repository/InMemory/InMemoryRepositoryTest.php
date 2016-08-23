<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Repository\InMemory;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Repository\InMemory\InMemoryRepository;

/**
 * Unit test class for FormattedImage InMemory repository class.
 */
class InMemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests save() method.
     */
    public function testSave()
    {
        $repository = new InMemoryRepository();
        $repository->save(new FormattedImage());
    }

    /**
     * Tests save() method.
     */
    public function testDelete()
    {
        $repository = new InMemoryRepository();
        $repository->delete(new FormattedImage());
    }
}
