<?php

namespace Synapse\Cmf\Bundle\Form\Type\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\DataType;

/**
 * Menu component form type.
 */
class MenuType extends AbstractType implements DataTransformerInterface
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
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return json_encode((array) $data);
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return json_decode($data, true);
    }

    /**
     * Menu component form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($builder
                ->create('tree', HiddenType::class, array(
                    'attr' => array(
                        'class' => 'synapse-tree-menu',
                        'data-labels' => json_encode(array(
                            'link' => array(
                                'name' => 'Name',
                                'url' => 'Url',
                            ),
                        )),
                    ),
                ))
                ->addModelTransformer($this)
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = array(
            'class' => 'synapse-menu-component',
        );
    }
}
