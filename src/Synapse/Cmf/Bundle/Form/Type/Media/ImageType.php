<?php

namespace Synapse\Cmf\Bundle\Form\Type\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Media\Image\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Media\Image\Domain\Action\ActionDispatcherDomain as ImageDomain;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;

/**
 * Custom form type for image use cases.
 */
class ImageType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var ImageDomain
     */
    protected $imageDomain;

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
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => UpdateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if ($data instanceof UpdateAction) {
            return $data;
        }
        if ($data instanceof ImageInterface) {
            return $this->imageDomain->getAction('edit', $data);
        }

        throw new TransformationFailedException(sprintf(
            'Image edition type only supports image or image update action. "%s" given.',
            gettype($data)
        ));
    }

    /**
     * Page form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this)
            ->add('name', TextType::class)
            ->add('title', TextType::class)
            ->add('headline', TextareaType::class, array(
                'required' => false,
            ))
            ->add('externalLink', TextType::class, array(
                'required' => false,
            ))
            ->add('alt', TextType::class, array(
                'required' => false,
            ))
            ->add('tags', TextType::class, array(
                'required' => false,
            ))
        ;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data->resolve();
    }
}
