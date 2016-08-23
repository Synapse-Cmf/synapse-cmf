<?php

namespace Synapse\Page\Bundle\Entity;

use Majora\Framework\Model\CollectionableInterface;
use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\TimedTrait;
use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Page entity class.
 */
class Page implements ContentInterface, CollectionableInterface
{
    use CollectionableTrait, NormalizableTrait, TimedTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var Page
     */
    protected $parent;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $online = false;

    /**
     * @var PageCollection
     */
    protected $children;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $meta;

    /**
     * @var array
     */
    protected $openGraph;

    /**
     * Doctrine NestedSet implementation.
     *
     * @var int
     */
    private $lft;

    /**
     * Doctrine NestedSet implementation.
     *
     * @var int
     */
    private $lvl;

    /**
     * Doctrine NestedSet implementation.
     *
     * @var int
     */
    private $rgt;

    /**
     * Doctrine NestedSet implementation.
     *
     * @var Page
     */
    private $root;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->title = '';
        $this->meta = array();
        $this->openGraph = array();
        $this->children = new PageCollection();
    }

    /**
     * Returns Page id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @see ContentInterface::getContentId()
     */
    public function getContentId()
    {
        return $this->getId();
    }

    /**
     * Define Theme id.
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
     * Returns object slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Define object slug.
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Returns Page name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define Page name.
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
     * Returns Page title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Define Page title.
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
     * Returns Page meta.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Define Page meta.
     *
     * @param array $meta
     *
     * @return self
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Returns Page open graph.
     *
     * @return array
     */
    public function getOpenGraph()
    {
        return $this->openGraph;
    }

    /**
     * Define Page open graph.
     *
     * @param array $openGraph
     *
     * @return self
     */
    public function setOpenGraph(array $openGraph)
    {
        $this->openGraph = $openGraph;

        return $this;
    }

    /**
     * Returns Page parent.
     *
     * @return Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Define Page parent.
     *
     * @param Page $parent
     *
     * @return self
     */
    public function setParent(Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Returns Page children.
     *
     * @return PageCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Define Page children.
     *
     * @param PageCollection $children
     *
     * @return self
     */
    public function setChildren(PageCollection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Returns Page path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Define Page path.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Returns Page lvl.
     *
     * @return int
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Returns Page root.
     *
     * @return Page
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Tests if page is online.
     *
     * @return bool
     */
    public function isOnline()
    {
        return $this->online;
    }

    /**
     * Define object online.
     *
     * @param bool $online
     *
     * @return self
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }
}
