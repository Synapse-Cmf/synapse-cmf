<?php

namespace Synapse\Cmf\Bundle\Form\Type\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormatOptions;

/**
 * Form type for formating options form definition.
 */
class FormatOptionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => FormatOptions::class,
            'empty_data' => function () {
                return new FormatOptions();
            },
        ));
    }

    /**
     * Options form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('x', NumberType::class, array())
            ->add('y', NumberType::class, array())
            ->add('width', NumberType::class, array())
            ->add('height', NumberType::class, array())
            ->add('rotate', NumberType::class, array())
            ->add('scaleX', NumberType::class, array())
            ->add('scaleY', NumberType::class, array())
        ;
    }
}
