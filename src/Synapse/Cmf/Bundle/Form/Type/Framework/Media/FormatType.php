<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\Image\Action\Dal\FormatAction;
use Synapse\Cmf\Framework\Media\Image\Domain\DomainInterface as ImageDomain;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;

/**
 * Formatted image creation type.
 */
class FormatType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var ImageDomain
     */
    protected $imageDomain;

    protected $format;

    /**
     * Construct.
     *
     * @param ImageDomain $imageDomain
     */
    public function __construct(ImageDomain $imageDomain)
    {
        $this->imageDomain = $imageDomain;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('format');
        $resolver->setAllowedTypes('format', FormatInterface::class);

        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => FormatAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if ($data instanceof FormatAction) {
            return $data;
        }
        if ($data instanceof ImageInterface) {
            return $this->imageDomain->getAction('format', $data);
        }

        throw new TransformationFailedException(sprintf(
            'Image format type only supports image or image format action. "%s" given.',
            gettype($data)
        ));
    }

    /**
     * Options form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->format = $options['format'];

        $builder
            ->addModelTransformer($this)
            ->add('options', FormatOptionsType::class, array())
        ;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data
            ->setFormat($this->format)
            ->resolve()
        ;
    }
}
