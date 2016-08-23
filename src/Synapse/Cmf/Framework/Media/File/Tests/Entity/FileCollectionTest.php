<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Entity;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Entity\FileCollection;

/**
 * Unit test class for FileCollection.
 */
class FileCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $fileCollection = new FileCollection();
        $fileCollection->denormalize(array(
            'file_1' => array('id' => 42),
            'file_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            File::class,
            $fileCollection->get('file_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            File::class,
            $fileCollection->get('file_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'file_1' => 42,
                'file_2' => 66,
            ),
            $fileCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
