<?php

namespace Synapse\Cmf\Framework\Media\File\Action;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for File Actions.
 *
 * @property $file
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var FileInterface
     */
    protected $file;

    /**
     * Initialisation function.
     *
     * @param FileInterface $file
     */
    public function init(FileInterface $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Return related File if defined.
     *
     * @return FileInterface|null $file
     */
    public function getFile()
    {
        return $this->file;
    }
}
