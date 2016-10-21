<?php

namespace Synapse\Cmf\Bundle\Form\Type\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Media\ImageChoiceType;
use Synapse\Cmf\Bundle\Form\Type\Theme\ComponentDataType;

/**
 * Gallery component form type.
 */
class GalleryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ComponentDataType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('image_formats');
    }

    /**
     * Gallery component form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array())
            ->add('medias', ImageChoiceType::class, array(
                'required' => false,
                'expanded' => false,
                'multiple' => true,
            ))
        ;
    }
}
