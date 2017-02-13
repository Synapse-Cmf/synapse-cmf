<?php

namespace Synapse\Page\Bundle\Action\Page;

use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Event\Page\Event as PageEvent;
use Synapse\Page\Bundle\Event\Page\Events as PageEvents;
use Synapse\Page\Bundle\Generator\PathGeneratorInterface;

/**
 * Page creation action representation.
 */
class CreateAction extends AbstractAction
{
    /**
     * @var Page
     */
    protected $parent;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $fullPath;

    /**
     * @var PathGeneratorInterface
     */
    protected $pathGenerator;

    /**
     * Construct.
     *
     * @param PathGeneratorInterface $pathGenerator
     */
    public function __construct(PathGeneratorInterface $pathGenerator)
    {
        $this->pathGenerator = $pathGenerator;
    }

    /**
     * Initialisation function.
     *
     * @param Page $page
     */
    public function init(Page $page = null)
    {
        $this->page = new Page();

        return $this;
    }

    /**
     * Page creation method.
     *
     * @return Page
     */
    public function resolve()
    {
        $this->page
            ->setName($this->name)
            ->setOnline(!empty($this->online))
            ->setTitle($this->title)
            ->setMeta(array('title' => $this->title))
            ->setPath($this->getFullPath())
        ;

        $this->assertEntityIsValid($this->page, array('Page', 'creation'));

        $this->fireEvent(
            PageEvents::PAGE_CREATED,
            new PageEvent($this->page, $this)
        );

        return $this->page;
    }

    /**
     * Returns action parent.
     *
     * @return Page|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Define action parent.
     *
     * @param Page $parent
     *
     * @return self
     */
    public function setParent(Page $parent = null)
    {
        $this->page->setParent($parent);

        return $this;
    }

    /**
     * Returns action path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Define action path.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        $this->fullPath = null;

        return $this;
    }

    /**
     * Generate page full path.
     *
     * @return string
     */
    protected function generateFullPath()
    {
        return $this->fullPath = $this->pathGenerator
            ->generatePath($this->page, $this->path ?: '')
        ;
    }

    /**
     * Returns action full path.
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath ?: $this->generateFullPath();
    }
}
