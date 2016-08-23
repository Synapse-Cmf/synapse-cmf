<?php

namespace Synapse\Cmf\Bundle\Form\Type\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\DataType;

/**
 * Static component form type.
 */
class StaticType extends AbstractType
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
        $resolver->setRequired('templates');
        $resolver->setAllowedTypes('templates', 'array');
    }

    /**
     * Static component form definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                if (empty($options['templates'])) {
                    return;
                }
                $event->getForm()->add('_template', ChoiceType::class, array(
                    'required' => true,
                    'choices' => $options['templates'],
                ));
            })
        ;
    }
}
