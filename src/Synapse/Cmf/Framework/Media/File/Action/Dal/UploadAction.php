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
        $this->setPhysicalFile(
            $this->sourceFile->move(
                $this->storePath,
                $this->sourceFile instanceof UploadedFile
                    ? sprintf('%s.%s',
                        $this->inflector->slugify(
                            preg_replace('/(\.[^\.]+)$/', '', $this->sourceFile->getClientOriginalName()),
                            '_'
                        ),
                        $this->sourceFile->guessExtension()
                    )
                    : sprintf('%s.%s',
                        $this->inflector->slugify(
                            $this->sourceFile->getBasename('.'.$this->sourceFile->getExtension()),
                            '_'
                        ),
                        $this->sourceFile->getExtension()
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
