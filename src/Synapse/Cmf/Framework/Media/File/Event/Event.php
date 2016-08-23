<?php

namespace Synapse\Cmf\Framework\Media\File\Event;

use Synapse\Cmf\Framework\Media\File\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * File specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param File           $file
     * @param AbstractAction $action
     */
    public function __construct(File $file, AbstractAction $action = null)
    {
        $this->file = $file;
        $this->action = $action;
    }

    /**
     * return related File.
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Return event subject, alias for getFile().
     *
     * @return File
     */
    public function getSubject()
    {
        return $this->getFile();
    }

    /**
     * Return action which have trigger this event.
     *
     * @return AbstractAction
     */
    public function getAction()
    {
        return $this->action;
    }
}
