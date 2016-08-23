<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Cmf\Framework\Media\File\Domain\DomainInterface as FileDomain;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\Image\Action\AbstractAction;

/**
 * Base class for Image Dal centric actions.
 *
 * @property $image
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;

    /**
     * @var FileDomain
     */
    protected $fileDomain;

    /**
     * @var string
     */
    protected $imageClass;

    /**
     * @var FileInterface
     */
    protected $file;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var string
     */
    protected $headline;

    /**
     * @var string
     */
    protected $externalLink;

    /**
     * @var string
     */
    protected $alt;

    /**
     * Construct.
     *
     * @param FileDomain $fileDomain
     * @param string     $imageClass
     */
    public function __construct(FileDomain $fileDomain, $imageClass)
    {
        $this->fileDomain = $fileDomain;
        $this->imageClass = $imageClass;
        $this->tags = array();
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
     * Returns action name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define action name.
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
     * Returns action title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Define action title.
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns action tags.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Define action tags.
     *
     * @param array|string $tags
     *
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Returns action headline.
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Define action headline.
     *
     * @param string $headline
     *
     * @return self
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Returns action alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Define action alt.
     *
     * @param string $alt
     *
     * @return self
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Returns action external link.
     *
     * @return string
     */
    public function getExternalLink()
    {
        return $this->externalLink;
    }

    /**
     * Define action external link.
     *
     * @param string $externalLink
     *
     * @return self
     */
    public function setExternalLink($externalLink)
    {
        $this->externalLink = $externalLink;

        return $this;
    }
}
