<?php

namespace Synapse\Page\Bundle\Form\Page;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Page Metadata custom form type.
 */
class MetadataType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'allow_extra_fields' => true,
            'supported_metadata' => array(),
        ));
    }

    /**
     * Page form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['supported_metadata'] as $metaName) {
            $builder->add($metaName, TextareaType::class, array(
                'required' => false,
            ));
        }
    }
}
