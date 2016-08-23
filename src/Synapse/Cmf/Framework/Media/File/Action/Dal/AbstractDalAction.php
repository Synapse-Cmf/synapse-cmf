<?php

namespace Synapse\Cmf\Framework\Media\File\Action\Dal;

use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Majora\Framework\Inflector\Inflector;
use Symfony\Component\Filesystem\Filesystem;
use Synapse\Cmf\Framework\Media\File\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\File\Loader\LoaderInterface as FileLoader;

/**
 * Base class for File Dal centric actions.
 *
 * @property $file
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;

    /**
     * @var FileLoader
     */
    protected $fileLoader;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Inflector
     */
    protected $inflector;

    /**
     * @var string
     */
    protected $storePath;

    /**
     * @var string
     */
    protected $fileClass;

    /**
     * Construct.
     *
     * @param FileLoader $fileLoader
     * @param Filesystem $filesystem
     * @param Inflector  $inflector
     * @param string     $storePath
     * @param string     $fileClass
     */
    public function __construct(
        FileLoader $fileLoader,
        Filesystem $filesystem,
        Inflector $inflector,
        $storePath,
        $fileClass
    ) {
        $this->fileLoader = $fileLoader;
        $this->filesystem = $filesystem;
        $this->inflector = $inflector;
        $this->storePath = $storePath;
        $this->fileClass = $fileClass;
    }
}
