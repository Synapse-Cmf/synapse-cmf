<?php

namespace Synapse\Page\Bundle\Form\PageMenu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Synapse\Cmf\Bundle\Form\Type\Theme\ComponentDataType;

/**
 * PageMenu component form type.
 */
class PageMenuType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ComponentDataType::class;
    }

    /**
     * Menu component form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data', CollectionType::class, array(
                'entry_type' => PageMenuItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'class' => 'synapse-page-menu-data',
                ],
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = array(
            'class' => 'synapse-page-menu-component',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'page_menu';
    }
}
