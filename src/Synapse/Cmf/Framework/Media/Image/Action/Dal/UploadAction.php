<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;

/**
 * Image uploading action representation.
 */
class UploadAction extends CreateAction
{
    /**
     * @var PhysicalFile
     */
    protected $sourceFile;

    /**
     * Image creation method.
     *
     * @return Image
     */
    public function resolve()
    {
        $this->setFile($this->fileDomain->upload(
            $this->sourceFile
        ));
        if (!$this->name) {
            $this->setName($this->getFile()->getOriginalName());
        }

        return parent::resolve();
    }

    /**
     * Returns action source file.
     *
     * @return PhysicalFile
     */
    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    /**
     * Define action source file.
     *
     * @param PhysicalFile $sourceFile
     *
     * @return self
     */
    public function setSourceFile(PhysicalFile $sourceFile)
    {
        $this->sourceFile = $sourceFile;

        return $this;
    }
}
