<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface as Imagine;
use Imagine\Image\Point;
use Majora\Framework\Inflector\Inflector;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\File\Domain\DomainInterface as FileDomain;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormatOptions;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event as FormattedImageEvent;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events as FormattedImageEvents;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\LoaderInterface as FormattedImageLoader;

/**
 * FormattedImage creation action representation.
 */
class CreateAction extends AbstractDalAction
{
    /**
     * @var string
     */
    protected $formattedImageClass;

    /**
     * @var FormattedImageLoader
     */
    protected $formattedImageLoader;

    /**
     * @var Inflector
     */
    protected $inflector;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Imagine
     */
    protected $formatter;

    /**
     * @var FileDomain
     */
    protected $fileDomain;

    /**
     * @var FileInterface
     */
    protected $file;

    /**
     * @var FormatInterface
     */
    protected $format;

    /**
     * @var FormatOptions
     */
    protected $options;

    /**
     * Construct.
     *
     * @param string               $formattedImageClass
     * @param FormattedImageLoader $formattedImageLoader
     * @param Inflector            $inflector
     * @param Filesystem           $filesystem
     * @param Imagine              $formatter
     * @param FileDomain           $fileDomain
     */
    public function __construct(
        $formattedImageClass,
        FormattedImageLoader $formattedImageLoader,
        Inflector $inflector,
        Filesystem $filesystem,
        Imagine $formatter,
        FileDomain $fileDomain
    ) {
        $this->formattedImageClass = $formattedImageClass;
        $this->formattedImageLoader = $formattedImageLoader;
        $this->inflector = $inflector;
        $this->filesystem = $filesystem;
        $this->formatter = $formatter;
        $this->fileDomain = $fileDomain;
    }

    /**
     * FormattedImage creation method.
     *
     * @return FormattedImage
     */
    public function resolve()
    {
        $originFile = $this->file->getPhysicalFile();

        // force format storage directory
        $this->filesystem->mkdir(
            $relatedDestDir = sprintf('%s/%s',
                dirname($originFile->getRealPath()),
                $this->inflector->slugify($this->format->getId(), '_')
            )
        );

        // format call
        $this->formatter
            ->open($originFile->getRealPath())
            ->crop(
                new Point($this->options->x, $this->options->y),
                new Box($this->options->width, $this->options->height)
            )
            ->save($formattedFileName = sprintf('%s/%s',
                $relatedDestDir,
                $originFile->getBasename()
            ))
        ;

        // File object creation (if required)
        $file = $this->fileDomain->create(new PhysicalFile($formattedFileName));

        $this->formattedImage = $this->formattedImageLoader->retrieveByFile($file)
            ?: new $this->formattedImageClass()
        ;
        $this->formattedImage
            ->setFormat($this->format)
            ->setFile($file)
        ;

        $this->assertEntityIsValid($this->formattedImage, array('FormattedImage', 'creation'));

        $this->fireEvent(
            FormattedImageEvents::FORMATTED_IMAGE_CREATED,
            new FormattedImageEvent($this->formattedImage, $this)
        );

        return $this->formattedImage;
    }

    /**
     * Returns action file.
     *
     * @return FileInterface
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Define action file.
     *
     * @param FileInterface $file
     *
     * @return self
     */
    public function setFile(FileInterface $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Returns action format.
     *
     * @return FormatInterface
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Define action format.
     *
     * @param FormatInterface $format
     *
     * @return self
     */
    public function setFormat(FormatInterface $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Returns action options.
     *
     * @return FormatOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Define action options.
     *
     * @param FormatOptions $options
     *
     * @return self
     */
    public function setOptions(FormatOptions $options)
    {
        $this->options = $options;

        return $this;
    }
}
