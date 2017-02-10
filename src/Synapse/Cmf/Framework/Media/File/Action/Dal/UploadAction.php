<?php

namespace Synapse\Cmf\Framework\Media\File\Action\Dal;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File creation action using File.
 */
class UploadAction extends CreateAction
{
    /**
     * @var PhysicalFile
     */
    protected $sourceFile;

    /**
     * Override to handle upload before normal creation.
     */
    public function resolve()
    {
        if ($this->sourceFile instanceof UploadedFile) {
            $extension = $this->sourceFile->guessExtension();
            $name = preg_filter('/^php(.+)/', '$1', $this->sourceFile->getBasename());
            $this->originalName = $this->sourceFile->getClientOriginalName();
        } else {
            $extension = $this->sourceFile->getExtension();
            $this->originalName = $name = $this->sourceFile->getBasename('.'.$extension);
        }

        $this->setPhysicalFile(
            $this->sourceFile->move(
                $this->storePath,
                sprintf('%s%s.%s',
                    strtolower($name),
                    base_convert(microtime(), 10, 36),
                    $extension
                )
            )
        );

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
     * Define action uploaded file.
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
