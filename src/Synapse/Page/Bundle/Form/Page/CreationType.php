<?php

namespace Synapse\Page\Bundle\Form\Page;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Page\Bundle\Action\CreateAction;
use Synapse\Page\Bundle\Domain\Action\ActionDispatcherDomain as PageDomain;
use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Loader\LoaderInterface as PageLoader;

/**
 * Page creation action related form type.
 */
class CreationType extends AbstractType
{
    /**
     * @var PageLoader
     */
    protected $pageLoader;

    /**
     * Construct.
     *
     * @param PageDomain $pageDomain
     * @param PageLoader $pageLoader
     */
    public function __construct(PageDomain $pageDomain, PageLoader $pageLoader)
    {
        $this->pageDomain = $pageDomain;
        $this->pageLoader = $pageLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => CreateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return $data instanceof CreateAction
            ? $data
            : $this->pageDomain->getAction('create')
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
            ->add('name', TextType::class)
            ->add('path', TextType::class)
            ->add('parent', ChoiceType::class, array(
                'required' => true,
                'choices' => $this->pageLoader->retrieveAll(),
                'choice_label' => function (Page $page) {
                    return sprintf('%s (/%s)', $page->getTitle(), $page->getPath());
                },
            ))
            ->add('submit', SubmitType::class)
        ;
    }
}
