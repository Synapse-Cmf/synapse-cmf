<?php

namespace Synapse\Cmf\Framework\Media\Media\Entity;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Media\File\Entity\File;

/**
 * Media entity abstract class.
 */
abstract class Media
{
    use CollectionableTrait, NormalizableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $externalLink;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var string
     */
    private $type;

    /**
     * Returns Media id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Media id.
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
     * Returns Media name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define Media name.
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
     * Returns Media title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Define Media title.
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
     * Returns Media file.
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Define Media file.
     *
     * @param File $file
     *
     * @return self
     */
    public function setFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Returns Media type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return Media web path.
     *
     * @return string
     */
    public function getWebPath()
    {
        return sprintf('%s%s',
            $this->file->getStorePath(),
            $this->file->getName()
        );
    }

    /**
     * Returns object external link.
     *
     * @return string
     */
    public function getExternalLink()
    {
        return $this->externalLink;
    }

    /**
     * Define object external link.
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
