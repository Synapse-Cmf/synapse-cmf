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
     * @var string
     */
    protected $originalName;

    /**
     * File creation method.
     *
     * @return File
     */
    public function resolve()
    {
        $this->file = (new $this->fileClass())
            ->setName(
                $this->physicalFile->getBasename()
            )
            // calculate original name (keep it for user data display)
            ->setOriginalName($this->originalName
                ?: $this->physicalFile->getBasename()
            )
            // calculate storage path (we only need path from config)
            ->setStorePath(str_replace(// trim base path
                realpath($this->storePath),
                '',
                str_replace(// trim filename
                    $this->physicalFile->getBasename(),
                    '',
                    $this->physicalFile->getRealpath()
                )
            ))
        ;

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
