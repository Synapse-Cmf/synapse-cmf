<?php

namespace Synapse\Cmf\Bundle\Form\Type\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\DataType;

/**
 * Free component form type.
 */
class FreeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return DataType::class;
    }

    /**
     * Free component form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('html', TextareaType::class, array(
            ))
        ;
    }
}
