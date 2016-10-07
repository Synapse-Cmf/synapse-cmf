<?php

namespace Synapse\Cmf\Bundle\Form\Type\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base form type for component data types.
 */
class ComponentDataType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('options', array());
    }
}
