<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Event\Events as ImageEvents;

/**
 * Image creation action representation.
 */
class CreateAction extends AbstractDalAction
{
    /**
     * @var PhysicalFile
     */
    protected $physicalFile;

    /**
     * Image creation method.
     *
     * @return Image
     */
    public function resolve()
    {
        if ($this->physicalFile) {
            $this->file = $this->fileDomain->create($this->physicalFile);
        }
        if (!$this->file) {
            throw new \BadMethodCallException(sprintf(
                'You cannot resolve Image CreateAction without giving a %s physical File or a %s logical File.',
                PhysicalFile::class,
                File::class
            ));
        }

        $this->image = (new $this->imageClass())
            ->setFile($this->file)
            ->setName($this->name ?: $this->file->getOriginalName())
            ->setTitle($this->title ?: $this->name)
            ->setTags($this->tags)
            ->setHeadline($this->headline)
            ->setAlt($this->alt)
        ;

        $this->assertEntityIsValid($this->image, array('Image', 'creation'));

        $this->fireEvent(
            ImageEvents::IMAGE_CREATED,
            new ImageEvent($this->image, $this)
        );

        return $this->image;
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
