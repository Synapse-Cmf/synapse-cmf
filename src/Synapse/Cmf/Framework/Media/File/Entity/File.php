<?php

namespace Synapse\Cmf\Framework\Media\File\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;

/**
 * File entity class.
 */
class File implements FileInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $storePath;

    /**
     * @var PhysicalFile
     */
    protected $physicalFile;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $originalName;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id', 'name', 'store_path'),
        );
    }

    /**
     * Returns File id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define File id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns File name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define File name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns File store path.
     *
     * @return string
     */
    public function getStorePath()
    {
        return $this->storePath;
    }

    /**
     * Define File store path.
     *
     * @param string $storePath
     *
     * @return self
     */
    public function setStorePath($storePath)
    {
        $this->storePath = $storePath;

        return $this;
    }

    /**
     * Returns File physical file.
     *
     * @return PhysicalFile
     */
    public function getPhysicalFile()
    {
        return $this->physicalFile;
    }

    /**
     * Define File physical file.
     *
     * @param PhysicalFile $physicalFile
     *
     * @return self
     */
    public function setPhysicalFile(PhysicalFile $physicalFile)
    {
        $this->physicalFile = $physicalFile;

        return $this;
    }

    /**
     * Returns File original name.
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Define File original name.
     *
     * @param string $originalName
     *
     * @return self
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }
}
