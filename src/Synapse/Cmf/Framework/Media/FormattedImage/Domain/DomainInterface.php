<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Domain;

use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormatOptions;
use Synapse\Cmf\Framework\Media\FormattedImage\Model\FormattedImageInterface;

/**
 * Interface for FormattedImage domain use cases.
 */
interface DomainInterface
{
    /**
     * Create a new FormattedImageInterface from given parameters.
     *
     * @param FileInterface   $file
     * @param FormatInterface $format
     * @param FormatOptions   $options
     *
     * @return FormattedImageInterface
     */
    public function create(FileInterface $file, FormatInterface $format, FormatOptions $options);

    /**
     * Trigger updating use case for given FormattedImage.
     *
     * @param FormattedImageInterface $formattedImage
     *
     * @return FormattedImageInterface
     */
    public function edit(FormattedImageInterface $formattedImage);

    /**
     * Trigger deletion use case for given FormattedImage.
     *
     * @param FormattedImageInterface $formattedImage
     */
    public function delete(FormattedImageInterface $formattedImage);
}
