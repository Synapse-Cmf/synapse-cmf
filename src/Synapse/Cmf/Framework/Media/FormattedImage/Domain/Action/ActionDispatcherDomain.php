<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Domain\Action;

use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Domain\DomainInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormatOptions;
use Synapse\Cmf\Framework\Media\FormattedImage\Model\FormattedImageInterface;

/**
 * FormattedImage domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see FormattedImageDomainInterface::create()
     */
    public function create(FileInterface $file, FormatInterface $format, FormatOptions $options)
    {
        return $this->getAction('create')
            ->setFile($file)
            ->setFormat($format)
            ->setOptions($options)
            ->resolve()
        ;
    }

    /**
     * @see FormattedImageDomainInterface::edit()
     */
    public function edit(FormattedImageInterface $formattedImage, ...$arguments)
    {
        return $this->getAction('edit', $formattedImage, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see FormattedImageDomainInterface::delete()
     */
    public function delete(FormattedImageInterface $formattedImage, ...$arguments)
    {
        return $this->getAction('delete', $formattedImage, ...$arguments)
            ->resolve()
        ;
    }
}
