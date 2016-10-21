<?php

namespace Synapse\Page\Bundle\Form\PageMenu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Synapse\Cmf\Bundle\Form\Type\Theme\ComponentDataType;
use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Loader\Page\LoaderInterface;

class PageMenuItemType extends AbstractType
{
    /**
     * @var array
     */
    protected $choices = array();

    /**
     * PageMenuItemType constructor.
     *
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->initChoices($loader);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return ComponentDataType::class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
                'attr' => array(
                    'class' => 'page-menu-item-label',
                    'placeholder' => 'Libellé',
                ),
            ))
            ->add('page', ChoiceType::class, array(
                'choices' => $this->choices,
                'placeholder' => '',
                'constraints' => array(
                    new Assert\Choice(array('choices' => array_values($this->choices))),
                    new Assert\NotBlank(),
                ),
                'attr' => array(
                    'class' => 'page-menu-item-page',
                ),
            ))
            ->add('position', HiddenType::class, array(
                'attr' => array(
                    'class' => 'page-menu-item-position',
                ),
            ));
    }

    /**
     * @param $loader
     *
     * @return $this
     */
    protected function initChoices($loader)
    {
        $this->choices = $loader->retrieveAll(array('online' => true))->reduce(function ($r, Page $page) {
            $r[$page->getName()] = $page->getId();

            return $r;
        }, array());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'page_menu_item';
    }
}
