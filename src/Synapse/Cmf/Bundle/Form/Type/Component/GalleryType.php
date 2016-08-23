<?php

namespace Synapse\Cmf\Bundle\Form\Type\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\DataType;
use Synapse\Cmf\Bundle\Form\Type\Framework\Media\ImageChoiceType;

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
        return DataType::class;
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
