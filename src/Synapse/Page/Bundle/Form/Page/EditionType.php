<?php

namespace Synapse\Page\Bundle\Form\Page;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Page\Bundle\Action\Page\UpdateAction;

/**
 * Page edition action related form type.
 */
class EditionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('synapse_theme');
        $resolver->setDefaults(array(
            'synapse_form_options' => array(
                'mapped' => true,
                'by_reference' => false,
                'property_path' => 'synapsePromises',
            ),
            'cascade_validation' => false,
            'data_class' => UpdateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return $data instanceof UpdateAction
            ? $data
            : $this->pageDomain->getAction('update')->init($data)
        ;
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
            ->add('online', ChoiceType::class, array(
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    'Yes' => true,
                    'No' => false,
                ),
            ))
            ->add('title', TextType::class, array())
            ->add('meta', MetadataType::class, array(
                'label' => false,
                'supported_metadata' => array('title', 'description', 'keywords'),
            ))
            ->add('submit', SubmitType::class)
        ;
    }
}
