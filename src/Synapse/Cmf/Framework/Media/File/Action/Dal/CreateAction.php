<?php

namespace Synapse\Cmf\Framework\Media\File\Action\Dal;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event as FileEvent;
use Synapse\Cmf\Framework\Media\File\Event\Events as FileEvents;

/**
 * File creation action representation.
 */
class CreateAction extends AbstractDalAction
{
    /**
     * @var PhysicalFile
     */
    protected $physicalFile;

    /**
     * File creation method.
     *
     * @return File
     */
    public function resolve()
    {
        $fileStorePath = str_replace(// trim base path
            realpath($this->storePath),
            '',
            str_replace(// trim filename
                $this->physicalFile->getBasename(),
                '',
                $this->physicalFile->getRealpath()
            )
        );

        // checks if file exists
        // no error if try to create same file : this is just as if someone replace a file into a folder
        $this->file = $this->fileLoader->retrieveOne(array(
            'name' => $this->physicalFile->getBasename(),
            'storePath' => $fileStorePath,
        ));
        if (!$this->file) {
            $this->file = new $this->fileClass();
            $this->file->setName($this->physicalFile->getBasename());
            $this->file->setStorePath($fileStorePath);
        }

        $this->assertEntityIsValid($this->file, array('File', 'creation'));

        $this->fireEvent(
            FileEvents::FILE_CREATED,
            new FileEvent($this->file, $this)
        );

        return $this->file;
    }

    /**
     * Returns action physical file.
     *
     * @return PhysicalFile
     */
    public function getPhysicalFile()
    {
        return $this->physicalFile;
    }

    /**
     * Define action physical file.
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
}
