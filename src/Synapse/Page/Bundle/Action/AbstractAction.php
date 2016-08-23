<?php

namespace Synapse\Page\Bundle\Action;

use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;
use Majora\Framework\Domain\Action\ActionCollection;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Base class for Page Actions.
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    use DalActionTrait;

    /**
     * @var Page
     */
    protected $page;

    /**
     * @var bool
     */
    protected $online;

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
    protected $meta;

    /**
     * @var array
     */
    protected $openGraph;

    /**
     * @var ActionCollection
     */
    protected $synapsePromises;

    /**
     * Initialisation function.
     *
     * @param Page $page
     */
    public function init(Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Return related Page if defined.
     *
     * @return Page|null $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Returns action template creation promises.
     *
     * @return ActionCollection
     */
    public function getSynapsePromises()
    {
        return $this->synapsePromises;
    }

    /**
     * Define action template creation promises.
     *
     * @param ActionCollection $synapsePromises
     *
     * @return self
     */
    public function setSynapsePromises(ActionCollection $synapsePromises)
    {
        $this->synapsePromises = $synapsePromises;

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
     * Returns action open graph.
     *
     * @return array
     */
    public function getOpenGraph()
    {
        return $this->openGraph;
    }

    /**
     * Define action open graph.
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
     * Returns action meta.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Define action meta.
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
     * Returns object online.
     *
     * @return bool
     */
    public function getOnline()
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
